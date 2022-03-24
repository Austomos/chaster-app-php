<?php

namespace ChasterApp\Interfaces;

use ChasterApp\Api\Conversations;
use ChasterApp\Api\SharedLocks;

interface ChasterFactoryInterface
{
    public function __construct(string $token);
    public function conversations(): Conversations;
    public function sharedLocks(): SharedLocks;
}