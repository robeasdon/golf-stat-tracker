<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Round;
use App\User;
use DB;

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

    public function getUserTrends($userId)
    {
        $userTotalsSubQuery = DB::table('rounds')
            ->join('scores', 'scores.round_id', '=', 'rounds.id')
            ->join('holes', 'holes.id', '=', 'scores.hole_id')
            ->where('rounds.user_id', $userId)
            ->select(
                'rounds.id',
                'rounds.date',
                DB::raw('sum(scores.strokes) as total_strokes'),
                DB::raw('sum(scores.putts) as total_putts'),
                DB::raw('sum(case when holes.par = 3 then scores.strokes end) as total_par3'),
                DB::raw('sum(case when holes.par = 4 then scores.strokes end) as total_par4'),
                DB::raw('sum(case when holes.par = 5 then scores.strokes end) as total_par5')
            )
            ->groupBy('rounds.id')
            ->orderBy('rounds.date', 'desc');

        $userTotalsSubQuerySql = $userTotalsSubQuery->toSql();

        $comparisonSubQuery = DB::table(DB::raw("({$userTotalsSubQuerySql}) as r1"))
            ->join(DB::raw("({$userTotalsSubQuerySql}) as r2"), function($join) {
                $join->on('r1.date', '<', 'r2.date');
            })
            ->mergeBindings($userTotalsSubQuery)
            ->mergeBindings($userTotalsSubQuery)
            ->select(
                DB::raw('(r2.total_strokes - r1.total_strokes) as score_diff'),
                DB::raw('(r2.total_putts - r1.total_putts) as putts_diff'),
                DB::raw('(r2.total_par3 - r1.total_par3) as par3_diff'),
                DB::raw('(r2.total_par4 - r1.total_par4) as par4_diff'),
                DB::raw('(r2.total_par5 - r1.total_par5) as par5_diff')
            )
            ->groupBy('r2.id')
            ->orderBy('r1.date', 'desc');

        return DB::table(DB::raw("({$comparisonSubQuery->toSql()}) as t1"))
            ->mergeBindings($comparisonSubQuery)
            ->select(
                DB::raw('sum(score_diff) / (count(*) + 1) as strokes'),
                DB::raw('sum(putts_diff) / (count(*) + 1) as putts'),
                DB::raw('sum(par3_diff) / (count(*) + 1) as strokes_par3'),
                DB::raw('sum(par4_diff) / (count(*) + 1) as strokes_par4'),
                DB::raw('sum(par5_diff) / (count(*) + 1) as strokes_par5')
            )->first();
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