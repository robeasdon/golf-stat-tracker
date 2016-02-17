<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Contracts\RoundRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\RoundRepository;
use App\Repositories\Eloquent\UserRepository;
use App\User;
use Illuminate\Http\Request;

class CompareController extends Controller
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
     * Create a new controller instance.
     * @param UserRepositoryInterface $user
     * @param RoundRepositoryInterface $round
     */
    public function __construct(UserRepositoryInterface $user, RoundRepositoryInterface $round)
    {
        $this->user = $user;
        $this->round = $round;
    }

    /**
     * Compare two users.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user1Id = $request->input('user');
        $user2Id = $request->input('to');

        // todo: make sure both valid users, and they are different

        $user1 = $this->user->getUser($user1Id);
        $user2 = $this->user->getUser($user2Id);

        $user1Stats = $this->user->getUserStats($user1Id);
        $user2Stats = $this->user->getUserStats($user2Id);

        $user1BestRounds = $this->round->getBestRoundsByUser($user1Id, 5);
        $user2BestRounds = $this->round->getBestRoundsByUser($user2Id, 5);

        $users = compact('user1', 'user2');
        $stats = ['user1' => $user1Stats, 'user2' => $user2Stats];
        $bestRounds = ['user1' => $user1BestRounds, 'user2' => $user2BestRounds];

        return view('compare.index', compact('stats', 'users', 'bestRounds'));
    }
}
