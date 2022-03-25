<?php

namespace ChasterApp\Api;

use ChasterApp\Data\Enum\SharedLockStatus;
use ChasterApp\Exception\ChasterJsonException;
use ChasterApp\Exception\ChasterRequestException;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Interfaces\Api\SharedLocksInterface;

class SharedLocks extends Request implements SharedLocksInterface
{
    private const LOCKS_SHARED_LOCKS = '/locks/shared-locks';

    /**
     * Find all user shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_findAll
     *
     * @param SharedLockStatus $status The shared lock status
     *
     *      Available values : active, archived
     *      Default value : active
     *
     * @return object
     *
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function get(SharedLockStatus $status = SharedLockStatus::active): object
    {
        return $this->getClient(self::LOCKS_SHARED_LOCKS, ['status' => $status]);
    }

    /**
     * Create a shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_create
     *
     * @param array $body Mandatory. Array with body parameters
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
     * @return object
     *
     * @throws InvalidArgumentChasterException
     */
    public function create(array $body): object
    {
        $this->checkMandatory($body, 'Body');
        return $this->postClient(self::LOCKS_SHARED_LOCKS, $body);
    }

    /**
     * Find a shared lock by id
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_findOne
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     *
     * @return object
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function find(string $sharedLockId): object
    {
        $this->checkMandatory($sharedLockId, 'Shared lock ID');
        return $this->getClient(self::LOCKS_SHARED_LOCKS . '/' . $sharedLockId);
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
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function update(string $sharedLockId, array $body): void
    {
        $this->checkMandatory($sharedLockId, 'Shared lock ID');
        $this->checkMandatory($body, 'Body');
        $this->putClient(self::LOCKS_SHARED_LOCKS . '/' . $sharedLockId);
    }

    /**
     * Archive a shared lock
     * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_archive
     *
     * @param string $sharedLockId Mandatory. The shared lock id
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function archive(string $sharedLockId): void
    {
        $this->checkMandatory($sharedLockId, 'Shared lock ID');
        $this->postClient(self::LOCKS_SHARED_LOCKS . '/' . $sharedLockId . '/archive');
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
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function extensions(string $sharedLockId, array $body): void
    {
        $this->checkMandatory($sharedLockId, 'Shared lock ID');
        $this->checkMandatory($body, 'Body');
        $this->putClient(self::LOCKS_SHARED_LOCKS . '/' . $sharedLockId . '/extensions', $body);
    }

}