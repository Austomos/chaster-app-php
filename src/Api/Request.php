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

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Provide category base route of the API
     * https://api.chaster.app/{category}
     * @example https://api.chaster.app/auth/profile
     * 'auth' is the category and 'profile' is the route
     *
     * @return string
     */
    abstract public function getBaseRoute(): string;

    /**
     * Concatenation of base route and following route information
     * @param string $route
     * @return string
     */
    public function getRoute(string $route = ''): string
    {
        $base = $this->getBaseRoute();
        if (!empty($base)) {
            if ($base[0] !== '/') {
                $base = '/' . $base;
            }
            if ($base[strlen($base) - 1] === '/') {
                $base = substr($base, 0, -1);
            }
        }
        if (!empty($route)) {
            if ($route[0] !== '/') {
                $route = '/' . $route;
            }
            if ($route[strlen($route) - 1] === '/') {
                $route = substr($route, 0, -1);
            }
        }
        return $base . $route;
    }

    /**
     * @throws RequestChasterException
     */
    protected function getClient(string $uri, ?array $query = null, array $options = []): void
    {
        if (!empty($query)) {
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
        if (!empty($body)) {
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
        if (!empty($body)) {
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
        $options['headers']['Authorization'] = 'Bearer ' . $this->token();
        $client = new Client([
            'base_uri' => self::BASE_URI,
        ]);

        try {
            $this->setResponse($client->request($method, $this->getRoute($uri), $options));
        } catch (GuzzleException $e) {
            throw new RequestChasterException('Request failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return string
     */
    public function token(): string
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
