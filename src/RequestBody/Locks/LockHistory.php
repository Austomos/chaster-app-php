<?php

namespace ChasterApp\RequestBody\Locks;

use ArrayObject;
use ChasterApp\Interfaces\RequestBody\Locks\LockHistoryInterface;

class LockHistory extends ArrayObject implements LockHistoryInterface
{
    public function setExtension(string $extension): LockHistoryInterface
    {
        $this->offsetSet('extension', $extension);
        return $this;
    }

    public function setLimit(int $limit): LockHistoryInterface
    {
        $this->offsetSet('limit', $limit);
        return $this;
    }

    public function setLastId(string $lastId): LockHistoryInterface
    {
        $this->offsetSet('lastId', $lastId);
        return $this;
    }
}
