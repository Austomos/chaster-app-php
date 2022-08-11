<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\LocksStatus;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\RequestBody\Locks\LockHistory;

interface LocksInterface
{
    public function locks(LocksStatus $status = LocksStatus::active): ResponseInterface;

    public function updateTime(string $lockId, array $body): ResponseInterface;
    public function freeze(string $lockId, array $body): ResponseInterface;

    /**
     * Return lock history
     * Returns a list of action logs
     * @link https://api.chaster.app/api/#/Locks/LockController_getLockHistory
     *
     * @param string $lockId
     * @param array|LockHistory $body
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function history(string $lockId, array|LockHistory $body): ResponseInterface;
}
