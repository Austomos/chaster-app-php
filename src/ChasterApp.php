<?php

namespace ChasterApp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

final class ChasterApp
{
    private string $token;

    public function __construct(string $apiToken)
    {
        $this->setToken($apiToken);
    }

    /**
     * @throws \ChasterApp\ChasterException
     */
    public function get(string $uri, array $options = []): array|object
    {
        return $this->client('GET', $uri, $options);
    }

    /**
     * @throws \ChasterApp\ChasterException
     */
    public function post(string $uri, ?array $json = null, array $options = []): array|object
    {
        if (is_array($json)) {
            $options['json'] = $json;
        }
        return $this->client('POST', $uri, $options);
    }

    /**
     * @throws \ChasterApp\ChasterException
     */
    protected function client(string $method, string $uri, array $options = []): array|object
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
            return json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
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