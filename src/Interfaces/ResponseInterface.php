<?php

namespace ChasterApp\Interfaces;

interface ResponseInterface extends \Psr\Http\Message\ResponseInterface
{
    public function getBodyObject(): object;
}
