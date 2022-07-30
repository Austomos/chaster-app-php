<?php

namespace ChasterApp;

use ChasterApp\Api\Conversations;
use ChasterApp\Api\Files;
use ChasterApp\Api\Keyholder;
use ChasterApp\Api\Locks;
use ChasterApp\Api\SharedLocks;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Interfaces\Api\ConversationsInterface;
use ChasterApp\Interfaces\Api\FilesInterface;
use ChasterApp\Interfaces\Api\KeyholderInterface;
use ChasterApp\Interfaces\Api\LocksInterface;
use ChasterApp\Interfaces\Api\SharedLocksInterface;
use ChasterApp\Interfaces\ChasterFactoryInterface;

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
            throw new InvalidArgumentChasterException('Access token or developer token is required', 400);
        }
        $this->token = $accessToken;
    }

    /**
     * Conversation route
     * @return ConversationsInterface
     */
    public function conversations(): ConversationsInterface
    {
        return new Conversations($this->token());
    }

    /**
     * Internal method to get the api token
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }

    /**
     * Files route
     * @return FilesInterface
     */
    public function files(): FilesInterface
    {
        return new Files($this->token());
    }

    /**
     * Keyholder routes
     * @return KeyholderInterface
     */
    public function keyholder(): KeyholderInterface
    {
        return new Keyholder($this->token());
    }

    /**
     * Locks routes
     * @return LocksInterface
     */
    public function locks(): LocksInterface
    {
        return new Locks($this->token());
    }

    /**
     * SharedLocks routes
     * @return SharedLocksInterface
     */
    public function sharedLocks(): SharedLocksInterface
    {
        return new SharedLocks($this->token());
    }
}
