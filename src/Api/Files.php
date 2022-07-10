<?php

namespace ChasterApp\Api;

use ChasterApp\Interfaces\Api\FilesInterface;

class Files extends Request implements FilesInterface
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
