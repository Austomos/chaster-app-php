<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Interfaces\ResponseInterface;

interface UsersInterface
{
    public function getUserById(string $userId): ResponseInterface;
}