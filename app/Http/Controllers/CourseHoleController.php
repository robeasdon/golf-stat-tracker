<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Contracts\HoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseHoleController extends Controller
{
    /**
     * @var CourseRepositoryInterface
     */
    private $course;

    /**
     * @var HoleRepositoryInterface
     */
    private $hole;

    /**
     * Create new controller instance.
     *
     * @param CourseRepositoryInterface $course
     * @param HoleRepositoryInterface $hole
     */
    public function __construct(CourseRepositoryInterface $course, HoleRepositoryInterface $hole)
    {
        $this->course = $course;
        $this->hole = $hole;
    }

    /**
     * Display the specified resource.
     *
     * @param $courseSlug
     * @param $holeNumber
     * @param Request $request
     * @return Response
     */
    public function show($courseSlug, $holeNumber, Request $request)
    {
        $course = $this->course->getCourse($courseSlug);

        $hole = $course->holes->filter(function ($hole) use ($holeNumber) {
            return $hole->number == $holeNumber;
        })->first();

        $user = $request->user();

        if ($user) {
            $stats = $this->hole->getUserStats($hole->id, $user->id);
        }

        return view('courses.holes.show', compact('course', 'hole', 'stats'));
    }
}
