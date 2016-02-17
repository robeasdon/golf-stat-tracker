<?php

namespace App\Repositories\Contracts;

interface CourseRepositoryInterface
{
    /**
     * Get a course.
     *
     * @param $slug
     * @return mixed
     */
    public function getCourse($slug);

    /**
     * List all courses as an array.
     *
     * @return mixed
     */
    public function listAllCourses();

    /**
     * Get all courses.
     *
     * @return mixed
     */
    public function getAllCourses();

    /**
     * Get a sortable list of courses.
     *
     * @param string $sort
     * @param string $direction
     * @return mixed
     */
    public function getSortableCourses($sort = 'course_name', $direction = 'asc');

    /**
     * Get user stats on a course.
     *
     * @param $courseId
     * @param $userId
     * @return mixed
     */
    public function getUserStats($courseId, $userId);

    /**
     * Get best rounds by a user on a course.
     *
     * @param $courseId
     * @param $userId
     * @return mixed
     */
    public function getUserBestRounds($courseId, $userId);
}