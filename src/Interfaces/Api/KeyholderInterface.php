<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Interfaces\ResponseInterface;

interface KeyholderInterface
{
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

    public function search(array $body): ResponseInterface;
}
