<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;

class Util extends Request
{
    /**
     * Check API availability on base URI
     *
     * @throws ResponseChasterException
     * @throws RequestChasterException
     */
    public function ping(): void
    {
        $this->getClient('');
        $this->checkResponseCode(200);
    }

    public function getBaseRoute(): string
    {
        // TODO: Implement getBaseRoute() method.
        return '';
    }
}
