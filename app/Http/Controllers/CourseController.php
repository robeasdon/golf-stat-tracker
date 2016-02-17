<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\Contracts\CourseRepositoryInterface;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * @var CourseRepositoryInterface
     */
    private $course;

    /**
     * Create a new controller instance.
     *
     * @param CourseRepositoryInterface $course
     */
    public function __construct(CourseRepositoryInterface $course)
    {
        $this->course = $course;
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

        $courses = $this->course->getSortableCourses($sort, $direction);

        return view('courses.index', compact('courses', 'sort', 'direction'));
    }

    /**
     * Display the specified resource.
     *
     * @param $courseSlug
     * @param Request $request
     * @return Response
     */
    public function show($courseSlug, Request $request)
    {
        $user = $request->user();
        $course = $this->course->getCourse($courseSlug);

        if ($user) {
            $bestRounds = $this->course->getUserBestRounds($course->id, $user->id);
            $stats = $this->course->getUserStats($course->id, $user->id);
        }

        return view('courses.show', compact('course', 'stats', 'bestRounds', 'user'));
    }
}
