<?php

namespace ChasterApp\Api;

use ChasterApp\ClientOptions;
use ChasterApp\Interfaces\Api\CommunityEventInterface;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\Request;

class CommunityEvent extends Request implements CommunityEventInterface
{

    /**
     * Get community event categories
     * @link https://api.chaster.app/api/#/Community%20Events/CommunityEventController_getCategories
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     *
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\ResponseChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     */
    public function getCategories(): ResponseInterface
    {
        $this->getClient('categories');
        return $this->response(200);
    }

    /**
     * Get community event categories
     * @link https://api.chaster.app/api/#/Community%20Events/CommunityEventController_getPeriodDetails
     *
     * @param array $body Mandatory. Array containing the body parameters
     *
     *      {
     *          'date': 'string'
     *      }
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     *
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\ResponseChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function getDetails(array $body): ResponseInterface
    {
        $this->isNotEmptyMandatoryArgument($body, 'Body');
        $this->postClient('', options: new ClientOptions(json: $body));
        return $this->response(200);
    }

    /**
     * @inheritDoc
     */
    public function getBaseRoute(): string
    {
        return 'community-event';
    }

}