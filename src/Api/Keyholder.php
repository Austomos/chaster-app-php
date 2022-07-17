<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use ChasterApp\Interfaces\Api\KeyholderInterface;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\Request;

class Keyholder extends Request implements KeyholderInterface
{
    public function getBaseRoute(): string
    {
        return 'keyholder';
    }

    /**
     * Search locked users
     * @link https://api.chaster.app/api/#/Keyholder/KeyholderController_searchLocks
     *
     * @param array $body Mandatory. Array containing the body parameters
     *
     *      {
     *          'criteria': {
     *              'sharedLocks': {
     *                  'sharedLockIds': [],
     *                  'includeKeyholderLocks': 'bool'
     *              }
     *          },
     *          'status': 'locked',
     *          'search': 'string',
     *          'page': 0,
     *          'limit': 0
     *      }
     *
     * @return object
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     */
    public function search(array $body): ResponseInterface
    {
        $this->checkMandatoryArgument($body, 'Body');
        $this->postClient('locks/search', $body);
        return $this->response(201);
    }
}
