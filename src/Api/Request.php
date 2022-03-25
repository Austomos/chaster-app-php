<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\{
    InvalidArgumentChasterException,
    RequestChasterException
};
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class Request extends Response
{
    private const BASE_URI = 'https://api.chaster.app';
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @throws RequestChasterException
     */
    protected function getClient(string $uri, ?array $query = null, array $options = []): void
    {
        if (is_array($query)) {
            $options['query'] = $query;
        }
        $this->client('GET', $uri, $options);
    }

    /**
     * @param string $uri URI specific of the call
     * @param array|null $body Array
     * @param array $options
     *
     * @throws RequestChasterException
     */
    protected function postClient(string $uri, ?array $body = null, array $options = []): void
    {
        if (is_array($body)) {
            $options['json'] = $body;
        }
        $this->client('POST', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array|null $body
     * @param array $options
     *
     * @throws RequestChasterException
     */
    protected function putClient(string $uri, ?array $body = null, array $options = []): void
    {
        if (is_array($body)) {
            $options['json'] = $body;
        }
        $this->client('PUT', $uri, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @throws RequestChasterException
     */
    protected function client(string $method, string $uri, array $options = []): void
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->getToken();
        $client = new Client([
            'base_uri' => self::BASE_URI,
        ]);
        try {
            $this->setResponse($client->request($method, $uri, $options));
        } catch (GuzzleException $e) {
            throw new RequestChasterException('Request failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @throws InvalidArgumentChasterException
     */
    protected function checkMandatory(mixed $value, string $name): void
    {
        if (empty($value)) {
            throw new InvalidArgumentChasterException(ucfirst($name) . ' is mandatory', 400);
        }
    }

}