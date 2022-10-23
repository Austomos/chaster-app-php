<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Interfaces\ResponseInterface;

interface CommunityEventInterface
{
    /**
     * Get community event categories
     * @link https://api.chaster.app/api/#/Community%20Events/CommunityEventController_getCategories
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function getCategories(): ResponseInterface;

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
     */
    public function getDetails(array $body): ResponseInterface;
}