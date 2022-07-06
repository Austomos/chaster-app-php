<?php

namespace ChasterApp\Api;

class Files extends Request
{
    public function upload(): array|object
    {
        return [];
    }

    public function getBaseRoute(): string
    {
        return 'files';
    }
}
