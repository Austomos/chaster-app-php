<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\SharedLockStatus;
use ChasterApp\Interfaces\RequestBody\SharedLocks\CreateSharedLockInterface;
use ChasterApp\Interfaces\ResponseInterface;

interface SharedLocksInterface
{
    /**
     * Set a shared lock as favorite
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockFavoriteController_setFavorite
     *
     * @param string $sharedLockId The shared lock id
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function addFavorite(string $sharedLockId): ResponseInterface;

    /**
     * Archive a shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_archive
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     */
    public function archive(string $sharedLockId): ResponseInterface;

    /**
     * Create a shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_create
     *
     * @param array|\ChasterApp\Interfaces\RequestBody\SharedLocks\CreateSharedLockInterface $body
     * Mandatory. Array with body parameters
     *
     *      [
     *          'minDuration': 0,
     *          'maxDuration': 0,
     *          'maxLimitDuration': 0,
     *          'minDate': '2022-03-25T16:35:16.270Z',
     *          'maxDate': '2022-03-25T16:35:16.270Z',
     *          'maxLimitDate': '2022-03-25T16:35:16.270Z',
     *          'displayRemainingTime': true,
     *          'limitLockTime': true,
     *          'isPublic': true,
     *          'maxLockedUsers': 0,
     *          'password': 'string',
     *          'requireContact': true,
     *          'name': 'string',
     *          'description': 'string',
     *          'photoId': 'string',
     *          'hideTimeLogs': true
     *      ]
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function create(array|CreateSharedLockInterface $body): ResponseInterface;

    /**
     * Set shared lock extensions
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockExtensionController_setSharedLockExtensions
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     * @param array $body Mandatory. Array with body parameters
     *
     *      {
     *          'extensions': [
     *              {
     *                  'slug': 'string',
     *                  'config': {},
     *                  'mode': 'cumulative',
     *                  'regularity': 0
     *              }
     *          ]
     *      }
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     *
     * @deprecated
     */
    public function extensions(string $sharedLockId, array $body): ResponseInterface;

    /**
     * Find a shared lock by id
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_findOne
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function find(string $sharedLockId): ResponseInterface;

    /**
     * Find all user shared lock
     * Returns a list of all user shared locks
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_findAll
     *
     * @param SharedLockStatus $status The shared lock status
     *
     *      Available values : active, archived
     *      Default value : active
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function get(SharedLockStatus $status = SharedLockStatus::active): ResponseInterface;

    /**
     * Get user favorite shared locks
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockFavoritesController_getFavoriteSharedLocks
     *
     * @param int $limit Mandatory. The limit of favorite shared locks.
     * default: 15
     * minimum: 0
     * maximum: 100
     * @param string|null $lastId Optional. The last id of shared lock
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function getFavorites(int $limit = 15, ?string $lastId = null): ResponseInterface;

    /**
     * Check if the shared lock is in user favorites
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockFavoriteController_isFavorite
     *
     * @param string $sharedLockId The shared lock id
     * @return \ChasterApp\Interfaces\ResponseInterface
     *  {
     *      'favorite': true
     *  }
     */
    public function isFavorite(string $sharedLockId): ResponseInterface;

    /**
     * Remove a favorite shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockFavoriteController_removeFavorite
     *
     * @param string $sharedLockId The shared lock id
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function removeFavorite(string $sharedLockId): ResponseInterface;

    /**
     * Update a shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_update
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     * @param array|\ChasterApp\Interfaces\RequestBody\SharedLocks\CreateSharedLockInterface $body Mandatory
     * Array with body parameters
     *
     *      {
     *          'minDuration': 0,
     *          'maxDuration': 0,
     *          'maxLimitDuration': 0,
     *          'minDate': '2022-03-25T16:54:08.153Z',
     *          'maxDate': '2022-03-25T16:54:08.153Z',
     *          'maxLimitDate': '2022-03-25T16:54:08.153Z',
     *          'displayRemainingTime': true,
     *          'limitLockTime': true,
     *          'isPublic': true,
     *          'maxLockedUsers': 0,
     *          'password': 'string',
     *          'requireContact': true,
     *          'name': 'string',
     *          'description': 'string',
     *          'photoId': 'string',
     *          'hideTimeLogs': true
     *      }
     */
    public function update(string $sharedLockId, array|CreateSharedLockInterface $body): ResponseInterface;
}
