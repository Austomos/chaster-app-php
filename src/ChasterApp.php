<?php

namespace ChasterApp;

use GuzzleHttp\Client;

final class ChasterApp
{
    private string $token;

    public function __construct(?string $apiToken = null)
    {
        if (!empty($apiToken)) {
            $this->setToken($apiToken);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function get(string $uri, array $options = []): array
    {
        return $this->client('GET', $uri, $options);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function post(string $uri, ?array $body = null, array $options = []): array
    {
        if (is_array($body)) {
            $options['body'] = $body;
        }
        return $this->client('POST', $uri, $options);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    protected function client(string $method, string $uri, array $options = []): array
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->getToken();
        $client = new Client([
            'base_uri' => 'https://api.chaster.app',
        ]);
        $response = $client->request($method, $uri, $options);

        return json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR | JSON_OBJECT_AS_ARRAY);
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