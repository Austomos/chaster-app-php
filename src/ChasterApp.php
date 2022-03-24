<?php

namespace ChasterApp;

use ChasterApp\Interfaces\ChasterFactoryInterface;
use ChasterApp\Parameters\Parameters;
use ChasterApp\Api\{
    Conversations,
    Files,
    Keyholder,
    Locks
};
use JetBrains\PhpStorm\Pure;

final class ChasterApp implements ChasterFactoryInterface
{
    private string $token;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->setToken($token);
    }

    #[Pure] public function conversations(): Conversations
    {
        return new Conversations($this->getToken());
    }

    public function files(): Files
    {
        return new Files($this->getToken());
    }

    public function keyholder(): Keyholder
    {
        return new Keyholder($this->getToken());
    }

    public function locks(): Locks
    {
        return new Locks($this->getToken());
    }


    #[Pure] public function parameters(): Parameters
    {
        return new Parameters();
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