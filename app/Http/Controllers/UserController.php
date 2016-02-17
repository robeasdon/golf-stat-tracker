<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\Contracts\RoundRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $user;

    /**
     * @var RoundRepositoryInterface
     */
    private $round;

    /**
     * Create a new controller instance
     *
     * @param UserRepositoryInterface $user
     * @param RoundRepositoryInterface $round
     */
    public function __construct(UserRepositoryInterface $user, RoundRepositoryInterface $round)
    {
        $this->user = $user;
        $this->round = $round;

        $this->middleware('auth', ['only' => ['follow', 'unfollow']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        $users = $this->user->getSortableUsers($sort, $direction);

        return view('users.index', compact('users', 'sort', 'direction'));
    }

    /**
     * Display the user.
     *
     * @param $userId
     * @return Response
     */
    public function show($userId)
    {
        $user = $this->user->getUser($userId);
        $stats = $this->user->getUserStats($userId);

        $parStats = [];
        $parStats['par3'] = $this->user->getUserStatsByPar($userId, 3);
        $parStats['par4'] = $this->user->getUserStatsByPar($userId, 4);
        $parStats['par5'] = $this->user->getUserStatsByPar($userId, 5);

        $chartData = [];

        foreach ($parStats as $key => $stat) {
            $chartData[$key][] = [
                'label' => 'Eagles',
                'count' => $stat->total_eagles
            ];

            $chartData[$key][] = [
                'label' => 'Birdies',
                'count' => $stat->total_birdies
            ];

            $chartData[$key][] = [
                'label' => 'Pars',
                'count' => $stat->total_pars
            ];

            $chartData[$key][] = [
                'label' => 'Bogies',
                'count' => $stat->total_bogies
            ];

            $chartData[$key][] = [
                'label' => 'Doubles',
                'count' => $stat->total_double_bogies
            ];
        }

        $latestRounds = $this->round->getLatestRoundsByUser($userId, 5);
        $bestRounds = $this->round->getBestRoundsByUser($userId, 5);

        return view(
            'users.show',
            compact('user', 'latestRounds', 'bestRounds', 'stats', 'chartData')
        );
    }

    /**
     * Display all a user's rounds.
     *
     * @param int $userId
     * @param Request $request
     * @return Response
     */
    public function rounds($userId, Request $request)
    {
        $sort = $request->input('sort', 'date');
        $direction = $request->input('direction', 'desc');

        $user = $this->user->getUser($userId);
        $rounds = $this->round->getSortableRounds($sort, $direction, $userId);

        return view('users.rounds', compact('user', 'rounds', 'sort', 'direction'));
    }

    /**
     * Display all users this user is following.
     *
     * @param $userId
     * @return \Illuminate\View\View
     */
    public function following($userId)
    {
        $user = $this->user->getUser($userId);
        $following = $this->user->getUserFollowing($user->id);

        return view('users.following', compact('user', 'following'));
    }

    /**
     * Display a list of this user's followers.
     *
     * @param $userId
     * @return \Illuminate\View\View
     */
    public function followers($userId)
    {
        $user = $this->user->getUser($userId);
        $followers = $this->user->getUserFollowers($user->id);

        return view('users.followers', compact('user', 'followers'));
    }

    /**
     * Follow a user.
     *
     * @param $userId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow($userId, Request $request)
    {
        $userToFollow = $this->user->getUser($userId);

        $request->user()->follow($userToFollow);

        return back();
    }

    /**
     * Unfollow a user.
     *
     * @param $userId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unfollow($userId, Request $request)
    {
        $userToUnfollow = $this->user->getUser($userId);

        $request->user()->unfollow($userToUnfollow);

        return back();
    }

    /**
     * Display a feed of rounds played by users this user is following.
     *
     * @param $userId
     * @return \Illuminate\View\View
     */
    public function feed($userId)
    {
        $user = $this->user->getUser($userId);
        $feed = $this->user->getUserPaginatedFeed($user->id, 10);

        return view('users.feed', compact('user', 'feed'));
    }
}
