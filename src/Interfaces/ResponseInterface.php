<?php

namespace ChasterApp\Interfaces;

interface ResponseInterface extends \Psr\Http\Message\ResponseInterface
{
    public function getBodyObject(): object;
    public function getBodyArray(): array;
}
