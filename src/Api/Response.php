<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\ResponseChasterException;
use JsonException;
use Psr\Http\Message\ResponseInterface;

abstract class Response
{
    private ResponseInterface $response;

    protected function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    protected function getReasonPhrase(): string
    {
        return $this->response->getReasonPhrase();
    }

    /**
     * @return int
     */
    protected function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @throws JsonChasterException
     */
    protected function getContents(): object
    {
        try {
            return (object) json_decode($this->response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonChasterException('Json decode failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    protected function getResponseContents(int $expectedCode): object
    {
        $this->checkResponseCode($expectedCode);
        return $this->getContents();
    }

    /**
     * @throws ResponseChasterException
     */
    protected function checkResponseCode(int $expectedCode): void
    {
        if ($this->getStatusCode() !== $expectedCode) {
            throw new ResponseChasterException(
                $this->getReasonPhrase(),
                $this->getStatusCode(),
                'Response failed, code expected: ' . $expectedCode . ', response code: ' . $this->getStatusCode()
                . ', reason: ' . $this->getReasonPhrase()
            );
        }
    }
}
