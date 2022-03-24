<?php

namespace ChasterApp\Api;

use ChasterApp\Data\Enum\SharedLockStatus;

class SharedLocks extends Request implements \ChasterApp\Interfaces\Api\SharedLocksInterface
{
    public function get(SharedLockStatus $status = SharedLockStatus::active): object
    {
        // TODO: Implement get() method.
    }

    public function create(array $body): object
    {
        // TODO: Implement create() method.
    }

    public function find(string $sharedLockId): object
    {
        // TODO: Implement find() method.
    }

    public function update(string $sharedLockId, array $body): void
    {
        // TODO: Implement update() method.
    }

    public function archive(string $sharedLockId): void
    {
        // TODO: Implement archive() method.
    }

    public function extensions(string $sharedLockId, array $body): void
    {
        // TODO: Implement extensions() method.
    }

}