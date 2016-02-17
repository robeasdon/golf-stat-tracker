<?php

namespace App\Repositories\Contracts;

interface TeeTypeRepositoryInterface
{
    /**
     * List all tee types.
     *
     * @return mixed
     */
    public function listAllTeeTypes();
}