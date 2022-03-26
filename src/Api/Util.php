<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;

final class Util extends Request
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
}