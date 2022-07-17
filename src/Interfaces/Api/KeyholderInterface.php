<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Interfaces\ResponseInterface;

interface KeyholderInterface
{
    public function search(array $body): ResponseInterface;
}
