<?php

namespace ChasterApp\Api;

use ChasterApp\Interfaces\Api\FilesInterface;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\Request;

class Files extends Request implements FilesInterface
{
    public function upload(): ResponseInterface
    {
        return [];
    }

    public function getBaseRoute(): string
    {
        return 'files';
    }
}
