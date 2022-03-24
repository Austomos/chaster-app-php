<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\SharedLockStatus;

interface SharedLocksInterface
{
    public function get(SharedLockStatus $status = SharedLockStatus::active): object;
    public function create(array $body): object;
    public function find(string $sharedLockId): object;
    public function update(string $sharedLockId, array $body): void;
    public function archive(string $sharedLockId): void;
    public function extensions(string $sharedLockId, array $body): void;
}