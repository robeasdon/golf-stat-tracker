<?php

namespace App\Repositories\Eloquent;

use App\Hole;
use App\Repositories\Contracts\HoleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class HoleRepository implements HoleRepositoryInterface
{
    public function getUserStats($holeId, $userId)
    {
        return DB::table('scores')
            ->join('holes', 'holes.id', '=', 'scores.hole_id')
            ->join('rounds', 'rounds.id', '=', 'scores.round_id')
            ->where('scores.hole_id', '=', $holeId)
            ->where('rounds.user_id', '=', $userId)
            ->select(
                DB::raw('sum(case when (scores.strokes - holes.par) = -2 then 1 else 0 end) as total_eagles'),
                DB::raw('sum(case when (scores.strokes - holes.par) = -1 then 1 else 0 end) as total_birdies'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 0 then 1 else 0 end) as total_pars'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 1 then 1 else 0 end) as total_bogies'),
                DB::raw('sum(case when (scores.strokes - holes.par) = 2 then 1 else 0 end) as total_double_bogies'),
                DB::raw('avg(scores.putts) as avg_putts'),
                DB::raw('avg(scores.strokes) as avg_strokes'),
                DB::raw('min(scores.strokes) as best_score'),
                DB::raw('count(scores.id) as times_played')
            )->first();
    }

    public function getHole($courseId, $holeNumber)
    {
        return Hole::where('course_id', '=', $courseId)
            ->where('number', '=', $holeNumber)
            ->firstOrFail();
    }
}