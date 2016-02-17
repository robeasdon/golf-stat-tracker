<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\RoundRequest;
use App\Http\Requests\UpdateRoundRequest;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Contracts\RoundRepositoryInterface;
use App\Repositories\Contracts\TeeTypeRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class RoundController extends Controller
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
     * @var CourseRepositoryInterface
     */
    private $course;

    /**
     * @var TeeTypeRepositoryInterface
     */
    private $teeType;

    /**
     * Create a new controller instance
     *
     * @param UserRepositoryInterface $user
     * @param RoundRepositoryInterface $round
     * @param CourseRepositoryInterface $course
     * @param TeeTypeRepositoryInterface $teeType
     */
    public function __construct(
        UserRepositoryInterface $user,
        RoundRepositoryInterface $round,
        CourseRepositoryInterface $course,
        TeeTypeRepositoryInterface $teeType
    ) {
        $this->user = $user;
        $this->round = $round;
        $this->course = $course;
        $this->teeType = $teeType;

        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('round.owner', ['only' => ['edit']]);
    }

    public function index(Request $request)
    {
        $sort = $request->input('sort', 'date');
        $direction = $request->input('direction', 'desc');

        $rounds = $this->round->getSortableRounds($sort, $direction);

        return view('rounds.index', compact('rounds', 'sort', 'direction'));
    }

    /**
     * Show a round.
     *
     * @param $roundId
     * @return Response
     */
    public function show($roundId)
    {
        $round = $this->round->getRound($roundId);

        return view('rounds.show', compact('round'));
    }

    /**
     * Show create page for a round.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $user = $request->user();

        $courses = $this->course->listAllCourses();
        $teeTypes = $this->teeType->listAllTeeTypes();

        return view('rounds.create', compact('courses', 'user', 'teeTypes'));
    }

    /**
     * Store a round.
     *
     * @param RoundRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RoundRequest $request)
    {
        $user = $request->user();

        $round = $this->round->store($user->id, $request);

        $request->session()->flash('success', 'Your new round has been saved.');

        return redirect(route('rounds.show', $round->id));
    }

    /**
     * Show edit page for a round.
     *
     * @param $roundId
     * @return \Illuminate\View\View
     */
    public function edit($roundId)
    {
        $courses = $this->course->listAllCourses();
        $teeTypes = $this->teeType->listAllTeeTypes();

        $round = $this->round->getRound($roundId);

        return view('rounds.edit', compact('round', 'courses', 'teeTypes'));
    }

    /**
     * Update a round.
     *
     * @param $roundId
     * @param UpdateRoundRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($roundId, UpdateRoundRequest $request)
    {
        $user = $request->user();

        $round = $this->round->update($user->id, $roundId, $request);

        $request->session()->flash('success', 'Your round has been updated.');

        return redirect(route('rounds.show', $round->id));
    }

    /**
     * Delete a round.
     *
     * @param $roundId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($roundId, Request $request)
    {
        $request->user()->rounds()->where('id', $roundId)->destroy();

        $request->session()->flash('success', 'Your round has been deleted.');

        return redirect(route('home'));
    }
}
