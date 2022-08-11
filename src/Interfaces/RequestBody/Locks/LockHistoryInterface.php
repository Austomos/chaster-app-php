<?php

namespace ChasterApp\Interfaces\RequestBody\Locks;

interface LockHistoryInterface
{
    public function setExtension(string $extension): self;
    public function setLimit(int $limit): self;
    public function setLastId(string $lastId): self;
}
