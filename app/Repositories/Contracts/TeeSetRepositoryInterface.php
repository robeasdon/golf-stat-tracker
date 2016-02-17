<?php

namespace App\Repositories\Contracts;

interface TeeSetRepositoryInterface
{
    /**
     * Get a tee set.
     *
     * @param $courseId
     * @param $teeTypeId
     * @return mixed
     */
    public function getTeeSet($courseId, $teeTypeId);
}