<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Round;
use App\User;
use DB;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getUser($id)
    {
        return User::findOrFail($id);
    }

    public function getSortableUsers($sort = 'name', $direction = 'asc')
    {
        if (!in_array($sort, ['name', 'created_at'])) {
            $sort = 'name';
        }

        return User::select(
                'users.id',
                'users.name',
                'users.created_at'
            )
            ->orderBy($sort, $direction)
            ->paginate(10);
    }

    public function getUserStats($userId)
    {
        return DB::table('scores')
            ->join('holes', 'holes.id', '=', 'scores.hole_id')
            ->join('rounds', 'rounds.id', '=', 'scores.round_id')
            ->where('rounds.user_id', '=', $userId)
            ->select(
                DB::raw('sum(case when (scores.strokes - holes.par) = -2 then 1 else 0 end) as total_eagles'),
                DB::raw('sum(case when (scores.strokes - holes.par) = -1 then 1 else 0 end) as total_birdies'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 0 then 1 else 0 end) as total_pars'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 1 then 1 else 0 end) as total_bogies'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 2 then 1 else 0 end) as total_double_bogies'),
                DB::raw('avg(scores.putts) as avg_putts_per_hole'),
                DB::raw('sum(scores.strokes) / count(distinct scores.round_id) as avg_strokes'),
                DB::raw('avg(case when holes.par = 3 then scores.strokes end) as avg_strokes_par3'),
                DB::raw('avg(case when holes.par = 4 then scores.strokes end) as avg_strokes_par4'),
                DB::raw('avg(case when holes.par = 5 then scores.strokes end) as avg_strokes_par5'),
                DB::raw('count(distinct scores.round_id) as rounds_played')
            )->first();
    }

    public function getUserStatsByPar($userId, $par)
    {
        return DB::table('scores')
            ->join('holes', 'holes.id', '=', 'scores.hole_id')
            ->join('rounds', 'rounds.id', '=', 'scores.round_id')
            ->where('rounds.user_id', $userId)
            ->where('holes.par', $par)
            ->select(
                DB::raw('sum(case when (scores.strokes - holes.par) = -2 then 1 else 0 end) as total_eagles'),
                DB::raw('sum(case when (scores.strokes - holes.par) = -1 then 1 else 0 end) as total_birdies'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 0 then 1 else 0 end) as total_pars'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 1 then 1 else 0 end) as total_bogies'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 2 then 1 else 0 end) as total_double_bogies')
            )->first();
    }

    public function getUserTrends(Collection $rounds)
    {
        $first = $rounds->first();
        $last = $rounds->last();
        $totalRounds = $rounds->count();

        $strokes = ($last->totalStrokes() - $first->totalStrokes()) / $totalRounds;
        $putts = ($last->totalPutts() - $first->totalPutts()) / $totalRounds;
        $strokesPar3 = ($last->totalStrokesPar(3) - $first->totalStrokesPar(3)) / $totalRounds;
        $strokesPar4 = ($last->totalStrokesPar(4) - $first->totalStrokesPar(4)) / $totalRounds;
        $strokesPar5 = ($last->totalStrokesPar(5) - $first->totalStrokesPar(5)) / $totalRounds;

        return compact('strokes', 'putts', 'strokesPar3', 'strokesPar4', 'strokesPar5');
    }

    public function getUserFollowing($userId)
    {
        return User::find($userId)->following()->paginate(10);
    }

    public function getUserFollowers($userId)
    {
        return User::find($userId)->followers()->paginate(10);
    }

    public function getUserLatestFeed($userId, $count)
    {
        return Round::with('user', 'teeSet.course')
            ->whereIn('user_id', function($query) use ($userId) {
                $query->select('follow_id')
                    ->from('user_follows')
                    ->where('user_id', $userId);
            })
            ->orderBy('rounds.date', 'desc')
            ->limit($count)
            ->get();
    }

    public function getUserPaginatedFeed($userId, $perPage)
    {
        return Round::with('user', 'teeSet.course')
            ->whereIn('user_id', function($query) use ($userId) {
                $query->select('follow_id')
                    ->from('user_follows')
                    ->where('user_id', $userId);
            })
            ->orderBy('rounds.date', 'desc')
            ->paginate($perPage);
    }
}