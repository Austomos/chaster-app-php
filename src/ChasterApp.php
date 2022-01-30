<?php

namespace ChasterApp;

use ChasterApp\Api\{
    Files,
    Locks
};

final class ChasterApp
{
    private string $token;

    /**
     * @param string $apiToken
     */
    public function __construct(string $apiToken)
    {
        $this->setToken($apiToken);
    }

    public function files(): Files
    {
        return new Files($this->getToken());
    }

    public function locks(): Locks
    {
        return new Locks($this->getToken());
    }

    /**
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