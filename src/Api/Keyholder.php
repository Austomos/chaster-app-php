<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Interfaces\Api\KeyholderInterface;

final class Keyholder extends Request implements KeyholderInterface
{
    private const KEYHOLDER = '/keyholder';

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
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function search(array $body): object
    {
        $this->checkMandatory($body, 'Body');
        return $this->postClient(self::KEYHOLDER . '/locks/search', $body);
    }
}