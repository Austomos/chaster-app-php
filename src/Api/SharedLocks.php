<?php

namespace ChasterApp\Api;

use ChasterApp\Data\Enum\SharedLockStatus;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use ChasterApp\Interfaces\Api\SharedLocksInterface;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\Request;
use ChasterApp\RequestBody\SharedLocks\CreateSharedLock;

class SharedLocks extends Request implements SharedLocksInterface
{
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
     *
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\ResponseChasterException
     */
    public function get(SharedLockStatus $status = SharedLockStatus::active): ResponseInterface
    {
        $this->getClient('locks/shared-locks', ['status' => $status]);
        return $this->response(200);
    }

    /**
     * Create a shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_create
     *
     * @param array|\ChasterApp\RequestBody\SharedLocks\CreateSharedLock $body Mandatory. Array with body parameters
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
     *
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\ResponseChasterException
     */
    public function create(array|CreateSharedLock $body): ResponseInterface
    {
        $body = $body instanceof CreateSharedLock ? $body->getArrayCopy() : $body;
        $this->checkMandatoryArgument($body, 'Body');
        $this->postClient('locks/shared-locks', $body);
        return $this->response(201);
    }

    /**
     * Find a shared lock by id
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_findOne
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     *
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\ResponseChasterException
     */
    public function find(string $sharedLockId): ResponseInterface
    {
        $this->checkMandatoryArgument($sharedLockId, 'Shared lock ID');
        $this->getClient('locks/shared-locks' . $sharedLockId);
        return $this->response(200);
    }

    /**
     * Update a shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_update
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     * @param array $body Mandatory. Array with body parameters
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
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     */
    public function update(string $sharedLockId, array $body): ResponseInterface
    {
        $this->checkMandatoryArgument($sharedLockId, 'Shared lock ID');
        $this->checkMandatoryArgument($body, 'Body');
        $this->putClient('locks/shared-locks' . $sharedLockId);
        return $this->response(200);
    }

    /**
     * Archive a shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_archive
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     */
    public function archive(string $sharedLockId): ResponseInterface
    {
        $this->checkMandatoryArgument($sharedLockId, 'Shared lock ID');
        $this->postClient($sharedLockId . '/archive');
        return $this->response(201);
    }

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
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     *
     * @deprecated
     */
    public function extensions(string $sharedLockId, array $body): ResponseInterface
    {
        $this->checkMandatoryArgument($sharedLockId, 'Shared lock ID');
        $this->checkMandatoryArgument($body, 'Body');
        $this->postClient('locks/shared-locks/extensions', $body);
        return $this->response(201);
    }

    /**
     * Note use, too many difference for base route
     * @return string
     */
    public function getBaseRoute(): string
    {
        return '';
    }

    /**
     * @throws \ChasterApp\Exception\ResponseChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function isFavorite(string $sharedLockId): ResponseInterface
    {
        $this->checkMandatoryArgument($sharedLockId, 'Shared lock ID');
        $this->getClient('/shared-locks/' . $sharedLockId . '/favorite');
        return $this->response(200);
    }

    /**
     * @throws \ChasterApp\Exception\ResponseChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function addFavorite(string $sharedLockId): ResponseInterface
    {
        $this->checkMandatoryArgument($sharedLockId, 'Shared lock ID');
        $this->putClient('/shared-locks/' . $sharedLockId . '/favorite');
        return $this->response(200);
    }

    public function removeFavorite(string $sharedLockId): ResponseInterface
    {
        $this->checkMandatoryArgument($sharedLockId, 'Shared lock ID');
        $this->deleteClient('/shared-locks/' . $sharedLockId . '/favorite');
        return $this->response(200);
    }

    public function getFavorites(array $body): ResponseInterface
    {
        // TODO: Implement getFavorites() method.
    }

}
