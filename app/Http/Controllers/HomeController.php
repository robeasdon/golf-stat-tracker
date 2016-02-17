<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RoundRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var RoundRepositoryInterface
     */
    private $round;

    /**
     * @var UserRepositoryInterface
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param RoundRepositoryInterface $round
     * @param UserRepositoryInterface $user
     */
    public function __construct(RoundRepositoryInterface $round, UserRepositoryInterface $user)
    {
        $this->round = $round;
        $this->user = $user;

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $rounds = $this->round->getRoundsByUser($user->id);
        $latestRounds = $rounds->take(-5)->reverse();
        $trends = $this->user->getUserTrends($user->id);
        $feed = $this->user->getUserLatestFeed($user->id, 5);

        $chartData = [];
        foreach ($rounds as $round) {
            $chartData[] = [
                'date' => $round->date->format('Y-m-d'),
                'strokes' => $round->totalStrokes(),
                'putts' => $round->totalPutts()
            ];
        }

        return view('home', [
            'rounds' => $rounds,
            'latestRounds' => $latestRounds,
            'chartData' => $chartData,
            'trends' => $trends,
            'user' => $user,
            'feed' => $feed
        ]);
    }
}
