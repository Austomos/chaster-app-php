<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\LocksStatus;
use ChasterApp\Interfaces\ResponseInterface;

interface LocksInterface
{
    public function locks(LocksStatus $status = LocksStatus::active): ResponseInterface;

    public function updateTime(string $lockId, array $body): ResponseInterface;
    public function freeze(string $lockId, array $body): ResponseInterface;
}
