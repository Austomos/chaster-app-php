<?php

namespace ChasterApp;

use ChasterApp\Interfaces\ChasterFactoryInterface;
use ChasterApp\Api\{Conversations, Files, Keyholder, Locks, SharedLocks, Util};
use JetBrains\PhpStorm\Pure;

/**
 *
 */
final class ChasterApp implements ChasterFactoryInterface
{
    private ChasterAuth $chasterAuth;

    /**
     * @param string $token API token
     */
    public function __construct(ChasterAuth $chasterAuth)
    {
        $this->chasterAuth = $chasterAuth;
    }

    /**
     * Conversation route
     * @return Conversations
     */
    #[Pure] public function conversations(): Conversations
    {
        return new Conversations($this->getToken());
    }

    /**
     * Files route
     * @return Files
     */
    #[Pure] public function files(): Files
    {
        return new Files($this->getToken());
    }

    /**
     * Keyholder routes
     * @return Keyholder
     */
    #[Pure] public function keyholder(): Keyholder
    {
        return new Keyholder($this->getToken());
    }

    /**
     * Locks routes
     * @return Locks
     */
    #[Pure] public function locks(): Locks
    {
        return new Locks($this->getToken());
    }

    /**
     * SharedLocks routes
     * @return SharedLocks
     */
    #[Pure] public function sharedLocks(): SharedLocks
    {
        return new SharedLocks($this->getToken());
    }

    /**
     * Internal method to get the api token
     * @return string
     */
    private function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

}