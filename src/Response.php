<?php

namespace ChasterApp;

use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Interfaces\ResponseInterface;
use JsonException;

class Response extends \GuzzleHttp\Psr7\Response implements ResponseInterface
{
    private array|object $json;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @throws \ChasterApp\Exception\JsonChasterException
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
        try {
            $this->json =  json_decode($this->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonChasterException('Json decode failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return object
     */
    public function getBodyObject(): object
    {
        return (object) $this->json;
    }

    /**
     * @return array
     */
    public function getBodyArray(): array
    {
        return (array) $this->json;
    }
}
