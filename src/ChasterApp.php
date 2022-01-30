<?php

namespace ChasterApp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final class ChasterApp
{
    private string $token;

    public function __construct(string $apiToken)
    {
        $this->setToken($apiToken);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function get(string $uri, array $options = []): array|object
    {
        return $this->client('GET', $uri, $options);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function post(string $uri, ?array $body = null, array $options = []): array|object
    {
        if (is_array($body)) {
            $options['body'] = $body;
        }
        return $this->client('POST', $uri, $options);
    }

    /**
     * @throws \ChasterApp\ChasterException
     */
    protected function client(string $method, string $uri, array $options = []): array
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->getToken();
        $client = new Client([
            'base_uri' => 'https://api.chaster.app',
        ]);
        try {
            $response = $client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new ChasterException('Request failed: ' . $e->getMessage(), $e->getCode());
        }
        try {
            return json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR | JSON_OBJECT_AS_ARRAY);
        } catch (\JsonException $e) {
            throw new ChasterException('Json decode failed: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return string
     */
    private function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }


}