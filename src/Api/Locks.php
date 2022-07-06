<?php

namespace ChasterApp\Api;

use ChasterApp\Data\Enum\LocksStatus;
use ChasterApp\Exception\{InvalidArgumentChasterException,
    JsonChasterException,
    RequestChasterException,
    ResponseChasterException,
};
use ChasterApp\Interfaces\Api\LocksInterface;
use ChasterApp\Utils\Utils;

class Locks extends Request implements LocksInterface
{
    use Utils;

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
     * @return object
     *
     * @throws JsonChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     */
    public function locks(LocksStatus $status = LocksStatus::active): object
    {
        $this->getClient('', ['status' => $status->name]);
        return $this->getResponseContents(200);
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
    public function updateTime(string $lockId, array $body): void
    {
        $this->checkMandatory($lockId, 'Lock ID');
        $this->checkMandatory($body, 'Body');
        $this->postClient($lockId . '/update-time', $body);
        $this->checkResponseCode(204);
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
    public function freeze(string $lockId, array $body): void
    {
        $this->checkMandatory($lockId, 'Lock ID');
        $this->checkMandatory($body, 'Body');
        $this->postClient($lockId . '/freeze', $body);
        $this->checkResponseCode(204);
    }
}
