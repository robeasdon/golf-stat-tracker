<?php

namespace App\Repositories\Eloquent;

use App\Hole;
use App\Http\Requests\RoundRequest;
use App\Http\Requests\UpdateRoundRequest;
use App\Repositories\Contracts\RoundRepositoryInterface;
use App\Round;
use App\Score;
use App\TeeSet;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoundRepository implements RoundRepositoryInterface
{
    public function getRound($roundId)
    {
        return Round::with('user', 'scores.hole', 'teeSet.teeType', 'teeSet.course')
            ->where('rounds.id', '=', $roundId)
            ->firstOrFail();
    }

    public function getAllRounds()
    {
        return Round::with('user', 'scores.hole', 'teeSet.teeType', 'teeSet.course')
            ->get();
    }

    public function getRoundsByUser($userId, $courseSlug = null)
    {
        $rounds = Round::with('scores.hole', 'teeSet.teeType');

        if ($courseSlug) {
            $rounds->with([
                'teeSet.course' => function ($query) use ($courseSlug) {
                    $query->where('courses.slug', '=', $courseSlug);
                }
            ]);
        } else {
            $rounds->with('teeSet.course');
        }

        return $rounds->where('user_id', '=', $userId)
            ->orderBy('date', 'asc')
            ->get();
    }

    public function getLatestRoundsByUser($userId, $count)
    {
        return User::find($userId)
            ->rounds()
            ->with('scores', 'teeSet.course')
            ->orderBy('date', 'desc')
            ->take($count)
            ->get();
    }

    public function getBestRoundsByUser($userId, $count)
    {
        return Round::join('scores', 'scores.round_id', '=', 'rounds.id')
            ->join('tee_sets', 'tee_sets.id', '=', 'rounds.tee_set_id')
            ->join('courses', 'courses.id', '=', 'tee_sets.course_id')
            ->where('rounds.user_id', '=', $userId)
            ->select(
                'rounds.id',
                'rounds.date',
                'rounds.user_id',
                DB::raw('sum(scores.strokes) as total_strokes'),
                DB::raw('sum(scores.putts) as total_putts'),
                'courses.slug as course_slug',
                'courses.name as course_name'
            )
            ->orderBy('total_strokes', 'asc')
            ->orderBy('rounds.date', 'desc')
            ->groupBy('rounds.id', 'courses.id')
            ->take($count)
            ->get();
    }

    public function getSortableRounds($sort = 'date', $direction = 'asc', $userId = null)
    {
        if (!in_array($sort, ['user_name', 'date', 'course_name', 'tee_type_name', 'strokes'])) {
            $sort = 'date';
        }

        $rounds = Round::join('users', 'users.id', '=', 'rounds.user_id')
            ->join('scores', 'scores.round_id', '=', 'rounds.id')
            ->join('tee_sets', 'tee_sets.id', '=', 'rounds.tee_set_id')
            ->join('tee_types', 'tee_types.id', '=', 'tee_sets.tee_type_id')
            ->join('courses', 'courses.id', '=', 'tee_sets.course_id')
            ->select(
                'rounds.id',
                'rounds.date',
                'rounds.user_id',
                'users.name as user_name',
                DB::raw('sum(scores.strokes) as strokes'),
                DB::raw('sum(scores.putts) as putts'),
                'tee_types.name as tee_type_name',
                'courses.slug as course_slug',
                'courses.name as course_name'
            );

        if ($userId) {
            $rounds->where('users.id', '=', $userId);
        }

        return $rounds->orderBy($sort, $direction)
            ->groupBy('rounds.id', 'users.id', 'tee_types.id', 'courses.id')
            ->paginate(10);
    }

    public function store($userId, RoundRequest $request)
    {
        $teeSet = TeeSet::where('course_id', '=', $request->course)
            ->where('tee_type_id', '=', $request->teeType)
            ->first();

        $date = Carbon::createFromDate($request->year, $request->month, $request->day);

        $round = new Round;
        $round->date = $date->toDateString();
        $round->user_id = $userId;
        $round->tee_set_id = $teeSet->id;

        $scores = [];

        for ($i = 1; $i <= 18; $i++) {
            $score = new Score;

            $score->strokes = $request->scores[$i];
            $score->putts = $request->putts[$i];
            $score->gir = null;
            $score->fairway = null;

            $hole = Hole::where('course_id', '=', $request->course)->where('number', '=', $i)->first();

            $score->hole_id = $hole->id;

            $scores[$i] = $score;
        }

        $round->save();
        $round->scores()->saveMany($scores);

        return $round;
    }

    public function update($userId, $roundId, UpdateRoundRequest $request)
    {
        $teeSet = TeeSet::where('course_id', '=', $request->course)
            ->where('tee_type_id', '=', $request->teeType)
            ->first();

        $date = Carbon::createFromDate($request->year, $request->month, $request->day);

        $round = $this->getRound($roundId, $userId);
        $round->date = $date->toDateString();
        $round->tee_set_id = $teeSet->id;

        $scores = $round->scores;

        for ($i = 1; $i <= 18; $i++) {
            $score = $scores[$i - 1];

            $score->strokes = $request->scores[$i];
            $score->putts = $request->putts[$i];
            $score->gir = null;
            $score->fairway = null;

            $hole = Hole::where('course_id', '=', $request->course)->where('number', '=', $i)->first();

            $score->hole_id = $hole->id;

            $score->save();
        }

        $round->save();

        return $round;
    }

    public function checkRoundBelongsToUser($userId, $roundId)
    {
        return Round::where('user_id', $userId)
            ->where('id', $roundId)
            ->exists();
    }
}