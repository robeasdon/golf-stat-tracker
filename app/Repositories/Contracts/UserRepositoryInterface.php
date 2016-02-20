<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Get a user.
     *
     * @param $id
     * @return mixed
     */
    public function getUser($id);

    /**
     * Get sortable list of users.
     *
     * @param string $sort
     * @param string $direction
     * @return mixed
     */
    public function getSortableUsers($sort = 'name', $direction = 'asc');

    /**
     * Get a user's stats.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserStats($userId);

    /**
     * Get a user's stats by par.
     *
     * @param $userId
     * @param $par
     * @return mixed
     */
    public function getUserStatsByPar($userId, $par);

    /**
     * Get a user's trends over a collection of rounds.
     *
     * @param Collection $rounds
     * @return mixed
     */
    public function getUserTrends(Collection $rounds);

    /**
     * Get all users a user is following.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserFollowing($userId);

    /**
     * Get all followers of a user.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserFollowers($userId);

    /**
     * Get a list of activity from users a user is following.
     *
     * @param $userId
     * @param $count
     * @return mixed
     */
    public function getUserLatestFeed($userId, $count);

    /**
     * Get a paginated list of activity from users a user is following.
     *
     * @param $userId
     * @param $perPage
     * @return mixed
     */
    public function getUserPaginatedFeed($userId, $perPage);
}