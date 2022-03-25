<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\{
    InvalidArgumentChasterException,
    JsonChasterException,
    RequestChasterException
};
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

abstract class Request
{
    private const BASE_URI = 'https://api.chaster.app';
    private string $token;
    private int $statusCode;
    private string $reasonPhrase;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    protected function getClient(string $uri, ?array $query = null, array $options = []): object
    {
        if (is_array($query)) {
            $options['query'] = $query;
        }
        return $this->client('GET', $uri, $options);
    }

    /**
     * @param string $uri URI specific of the call
     * @param array|null $body Array
     * @param array $options
     *
     * @return object
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    protected function postClient(string $uri, ?array $body = null, array $options = []): object
    {
        if (is_array($body)) {
            $options['json'] = $body;
        }
        return $this->client('POST', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array|null $body
     * @param array $options
     *
     * @return object
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    protected function putClient(string $uri, ?array $body = null, array $options = []): object
    {
        if (is_array($body)) {
            $options['json'] = $body;
        }
        return $this->client('PUT', $uri, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @return array|object
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    protected function client(string $method, string $uri, array $options = []): object
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->getToken();
        $client = new Client([
            'base_uri' => self::BASE_URI,
        ]);
        try {
            $response = $client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new RequestChasterException('Request failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
        $this->statusCode = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
        try {
            return json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonChasterException('Json decode failed: ' . $e->getMessage(), $e->getCode(), $e);
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