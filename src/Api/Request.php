<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\ChasterJsonException;
use ChasterApp\Exception\ChasterRequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

abstract class Request
{
    private const BASE_URI = 'https://api.chaster.app';
    private string $token;

    private int $statusCode;

    public function __construct(string $token)
    {
        $this->setToken($token);
    }

    /**
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function get(string $uri, array $options = []): array|object
    {
        return $this->client('GET', $uri, $options);
    }

    /**
     * @return string
     */
    protected function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function post(string $uri, ?array $json = null, array $options = []): array|object
    {
        if (is_array($json)) {
            $options['json'] = $json;
        }
        return $this->client('POST', $uri, $options);
    }

    /**
     * @throws \ChasterApp\Exception\ChasterRequestException
     * @throws \ChasterApp\Exception\ChasterJsonException
     */
    protected function client(string $method, string $uri, array $options = []): array|object
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->getToken();
        $client = new Client([
            'base_uri' => self::BASE_URI,
        ]);
        try {
            $response = $client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new ChasterRequestException('Request failed: ' . $e->getMessage(), $e->getCode());
        }
        $this->setStatusCode($response->getStatusCode());
        try {
            return json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ChasterJsonException('Json decode failed: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param string $token
     */
    protected function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

}