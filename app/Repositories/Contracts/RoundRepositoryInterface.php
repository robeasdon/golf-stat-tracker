<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\RoundRequest;
use App\Http\Requests\UpdateRoundRequest;

interface RoundRepositoryInterface
{
    /**
     * Get a round.
     *
     * @param $roundId
     * @return mixed
     */
    public function getRound($roundId);

    /**
     * Get all rounds.
     *
     * @return mixed
     */
    public function getAllRounds();

    /**
     * Get all of a user's rounds, optionally specifying a course
     *
     * @param $userId
     * @param null $courseId
     * @return mixed
     */
    public function getRoundsByUser($userId, $courseId = null);

    /**
     * Get a user's latest rounds
     *
     * @param $userId
     * @param $count
     * @return mixed
     */
    public function getLatestRoundsByUser($userId, $count);

    /**
     * Get a user's best rounds
     *
     * @param $userId
     * @param $count
     * @return mixed
     */
    public function getBestRoundsByUser($userId, $count);

    /**
     * Get a sortable list of a user's rounds
     *
     * @param string $sort
     * @param string $direction
     * @param null $userId
     * @return mixed
     */
    public function getSortableRounds($sort = 'date', $direction = 'asc', $userId = null);

    /**
     * Store a new round.
     *
     * @param $userId
     * @param RoundRequest $request
     * @return mixed
     */
    public function store($userId, RoundRequest $request);

    /**
     * Update a round.
     *
     * @param $userId
     * @param $roundId
     * @param UpdateRoundRequest $request
     * @return mixed
     */
    public function update($userId, $roundId, UpdateRoundRequest $request);

    /**
     * Check a round is owned by a user.
     *
     * @param $userId
     * @param $roundId
     * @return mixed
     */
    public function checkRoundBelongsToUser($userId, $roundId);
}