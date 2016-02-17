<?php

namespace App\Repositories\Eloquent;

use App\Course;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Round;
use DB;

class CourseRepository implements CourseRepositoryInterface
{
    public function getCourse($slug)
    {
        return Course::with('holes.tees', 'teeSets.teeType', 'teeSets.tees')
            ->where('courses.slug', '=', $slug)
            ->firstOrFail();
    }

    public function listAllCourses()
    {
        return Course::orderBy('name', 'asc')->lists('name', 'id');
    }

    public function getAllCourses()
    {
        return Course::with('holes.tees', 'teeSets.teeType', 'teeSets.tees')->get();
    }

    public function getSortableCourses($sort = 'name', $direction = 'asc')
    {
        if (!in_array($sort, ['name', 'par'])) {
            $sort = 'name';
        }

        return Course::join('holes', 'holes.course_id', '=', 'courses.id')
            ->select(
                'courses.slug',
                'courses.name',
                DB::raw('sum(holes.par) as par')
            )
            ->orderBy($sort, $direction)
            ->groupBy('courses.id')
            ->paginate(10);
    }

    public function getUserStats($courseId, $userId)
    {
        return DB::table('scores')
            ->join('holes', 'holes.id', '=', 'scores.hole_id')
            ->join('rounds', 'rounds.id', '=', 'scores.round_id')
            ->where('holes.course_id', '=', $courseId)
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

    public function getUserBestRounds($courseId, $userId)
    {
        return Round::join('scores', 'scores.round_id', '=', 'rounds.id')
            ->join('tee_sets', 'tee_sets.id', '=', 'rounds.tee_set_id')
            ->join('courses', 'courses.id', '=', 'tee_sets.course_id')
            ->where('courses.id', '=', $courseId)
            ->where('rounds.user_id', $userId)
            ->select(
                'rounds.id',
                'rounds.date',
                'rounds.user_id',
                'courses.slug as course_slug',
                'courses.name as course_name',
                DB::raw('sum(scores.strokes) as total_strokes')
            )
            ->groupBy('rounds.id')
            ->orderBy('total_strokes', 'asc')
            ->orderBy('rounds.date', 'desc')
            ->take(5)
            ->get();
    }
}