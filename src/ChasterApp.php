<?php

namespace ChasterApp;

use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Interfaces\ChasterFactoryInterface;
use ChasterApp\Api\{Conversations, Files, Keyholder, Locks, SharedLocks, Util};
use JetBrains\PhpStorm\Pure;

/**
 *
 */
class ChasterApp implements ChasterFactoryInterface
{
    private string $token;

    /**
     * @param string $accessToken
     * Token used to authenticate requests
     * You can provide token access from oauth2 authentification or your developer token
     * oauth2 authentification is recommended
     *
     * For oauth2 authenticate, please visit https://docs.chaster.app/api-oauth-2
     * oauth2-client library is available at https://github.com/Austomos/oauth2-chaster-app
     *
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function __construct(string $accessToken)
    {
        if (empty($accessToken)) {
            throw new InvalidArgumentChasterException('Access token or developer token is required');
        }
        $this->token = $accessToken;
    }

    /**
     * Conversation route
     * @return Conversations
     */
    #[Pure] public function conversations(): Conversations
    {
        return new Conversations($this->token());
    }

    /**
     * Files route
     * @return Files
     */
    #[Pure] public function files(): Files
    {
        return new Files($this->token());
    }

    /**
     * Keyholder routes
     * @return Keyholder
     */
    #[Pure] public function keyholder(): Keyholder
    {
        return new Keyholder($this->token());
    }

    /**
     * Locks routes
     * @return Locks
     */
    #[Pure] public function locks(): Locks
    {
        return new Locks($this->token());
    }

    /**
     * SharedLocks routes
     * @return SharedLocks
     */
    #[Pure] public function sharedLocks(): SharedLocks
    {
        return new SharedLocks($this->token());
    }

    /**
     * Internal method to get the api token
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }
}
