<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\TeeTypeRepositoryInterface;
use App\TeeType;

class TeeTypeRepository implements TeeTypeRepositoryInterface
{
    public function listAllTeeTypes()
    {
        return TeeType::orderBy('id', 'asc')->lists('name', 'id');
    }
}