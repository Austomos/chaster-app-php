<?php

namespace ChasterApp\Interfaces\Api;

interface KeyholderInterface
{
    public function search(array $body): object;
}