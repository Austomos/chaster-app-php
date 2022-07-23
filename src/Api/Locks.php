<?php

namespace ChasterApp\Api;

use ChasterApp\Data\Enum\LocksStatus;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use ChasterApp\Interfaces\Api\LocksInterface;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\Request;

class Locks extends Request implements LocksInterface
{
    public function getBaseRoute(): string
    {
        return 'locks';
    }

    /**
     * Get user locks
     * Returns a list of all user locks
     * By default, only active locks are returned.
     * @link https://api.chaster.app/api/#/Locks/LockController_findAll
     *
     * @param LocksStatus $status The lock status
     *                              Available values : active, archived, all
     *                              Default value : active
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     *
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\ResponseChasterException
     */
    public function locks(LocksStatus $status = LocksStatus::active): ResponseInterface
    {
        $this->getClient('', ['status' => $status->name]);
        return $this->response(200);
    }

    /**
     * Update lock duration
     * Adds or removes duration to a lock. Keyholders can add or remove time, while wearers can only add time.
     * @link https://api.chaster.app/api/#/Locks/LockController_updateTime
     *
     * @param string $lockId Mandatory. The lock id
     * @param array $body Mandatory. Array containing the body parameters
     *
     *      {
     *          'duration': 0
     *      }
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     */
    public function updateTime(string $lockId, array $body): ResponseInterface
    {
        $this->checkMandatoryArgument($lockId, 'Lock ID');
        $this->checkMandatoryArgument($body, 'Body');
        $this->postClient($lockId . '/update-time', $body);
        return $this->response(204);
    }

    /**
     * Freeze a lock
     * Freezes a lock. Keyholders can use this endpoint to freeze wearer's locks.
     * @link https://api.chaster.app/api/#/Locks/LockController_setFreeze
     *
     * @param string $lockId Mandatory. The lock id
     * @param array $body Mandatory. Array containing the body parameters
     *
     *      {
     *          'isFrozen': true
     *      }
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     */
    public function freeze(string $lockId, array|LockFrozen $body): ResponseInterface
    {
        $this->checkMandatoryArgument($lockId, 'Lock ID');
        $this->checkMandatoryArgument($body, 'Body');
        $this->postClient($lockId . '/freeze', $body);
        return $this->response(204);
    }
}
