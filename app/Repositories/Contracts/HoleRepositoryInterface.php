<?php

namespace App\Repositories\Contracts;

interface HoleRepositoryInterface
{
    /**
     * Get user stats on a hole.
     *
     * @param $holeId
     * @param $userId
     * @return mixed
     */
    public function getUserStats($holeId, $userId);

    /**
     * Get a hole.
     *
     * @param $courseId
     * @param $holeNumber
     * @return mixed
     */
    public function getHole($courseId, $holeNumber);
}