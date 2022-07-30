<?php

namespace ChasterApp\Interfaces;

use ChasterApp\Interfaces\Api\ConversationsInterface;
use ChasterApp\Interfaces\Api\FilesInterface;
use ChasterApp\Interfaces\Api\KeyholderInterface;
use ChasterApp\Interfaces\Api\LocksInterface;
use ChasterApp\Interfaces\Api\SharedLocksInterface;

interface ChasterFactoryInterface
{
    public function conversations(): ConversationsInterface;

    public function files(): FilesInterface;

    public function keyholder(): KeyholderInterface;

    public function locks(): LocksInterface;

    public function sharedLocks(): SharedLocksInterface;

    public function __construct(string $accessToken);
}
