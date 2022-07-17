<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\SharedLockStatus;
use ChasterApp\Interfaces\ResponseInterface;

interface SharedLocksInterface
{
    public function get(SharedLockStatus $status = SharedLockStatus::active): ResponseInterface;
    public function create(array $body): ResponseInterface;
    public function find(string $sharedLockId): ResponseInterface;
    public function update(string $sharedLockId, array $body): ResponseInterface;
    public function archive(string $sharedLockId): ResponseInterface;
    public function extensions(string $sharedLockId, array $body): ResponseInterface;

    /**
     * Check if the shared lock is in user favorites
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockFavoriteController_isFavorite
     *
     * @param string $sharedLockId The shared lock id
     * @return \ChasterApp\Interfaces\ResponseInterface
     *  {
     *      'favorite': true
     *  }
     * http code: 200
     */
    public function isFavorite(string $sharedLockId): ResponseInterface;

    /**
     * Set a shared lock as favorite
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockFavoriteController_setFavorite
     *
     * @param string $sharedLockId The shared lock id
     * @return \ChasterApp\Interfaces\ResponseInterface
     * http code: 200
     */
    public function addFavorite(string $sharedLockId): ResponseInterface;

    /**
     * Remove a favorite shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockFavoriteController_removeFavorite
     *
     * @param string $sharedLockId The shared lock id
     * @return \ChasterApp\Interfaces\ResponseInterface
     * http code: 200
     */
    public function removeFavorite(string $sharedLockId): ResponseInterface;

    /**
     * Get user favorite shared locks
     * @param array $body
     *  {
     *      'limit': 15,
     *      'lastId': 'string'
     *  }
     * @return \ChasterApp\Interfaces\ResponseInterface
     * http code: 201
     */
    public function getFavorites(array $body): ResponseInterface;
}
