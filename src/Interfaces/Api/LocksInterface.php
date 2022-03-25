<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\LocksStatus;

interface LocksInterface
{
    public function get(LocksStatus $status = LocksStatus::active): object;

    public function updateTime(string $lockId, array $body): void;
    public function freeze(string $lockId, array $body): void;
}