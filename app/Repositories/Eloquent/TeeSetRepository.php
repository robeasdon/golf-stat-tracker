<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\TeeSetRepositoryInterface;
use App\TeeSet;

class TeeSetRepository implements TeeSetRepositoryInterface
{
    public function getTeeSet($courseId, $teeTypeId)
    {
        return TeeSet::where('course_id', '=', $courseId)
            ->where('tee_type_id', '=', $teeTypeId)
            ->first();
    }
}