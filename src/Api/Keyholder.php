<?php

namespace ChasterApp\Api;

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
     *                  'sharedLockIds': string[],
     *                  'includeKeyholderLocks': 'bool'
     *              }
     *          },
     *          'status': 'locked',
     *          'search': 'string',
     *          'page': 0,
     *          'limit': 0
     *      }
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     *
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\ResponseChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     */
    public function search(array $body): ResponseInterface
    {
        $this->isNotEmptyMandatoryArgument($body, 'Body');
        $this->postClient('/locks/search', $body);
        return $this->response(201);
    }
}
