<?php

namespace ChasterApp\Interfaces;

use ChasterApp\Api\Conversations;
use ChasterApp\Api\Files;
use ChasterApp\Api\Keyholder;
use ChasterApp\Api\Locks;
use ChasterApp\Api\SharedLocks;
use ChasterApp\Interfaces\Api\KeyholderInterface;

interface ChasterFactoryInterface
{
    public function __construct(string $accessToken);
    public function conversations(): Conversations;
    public function files(): Files;
    public function keyholder(): KeyholderInterface;
    public function locks(): Locks;
    public function sharedLocks(): SharedLocks;
}
