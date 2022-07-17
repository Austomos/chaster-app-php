<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Interfaces\ResponseInterface;
use JsonException;

class Response extends \GuzzleHttp\Psr7\Response implements ResponseInterface
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(\Psr\Http\Message\ResponseInterface $response)
    {
        parent::__construct(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );
    }

    /**
     * @throws JsonChasterException
     */
    public function getBodyObject(): object
    {
        try {
            return (object) json_decode($this->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonChasterException('Json decode failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
