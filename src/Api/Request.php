<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\{InvalidArgumentChasterException,
    JsonChasterException,
    RequestChasterException,
    ResponseChasterException};
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

abstract class Request
{
    private const BASE_URI = 'https://api.chaster.app';
    protected Client $client;
    private ResponseInterface $response;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ]
        ]);
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
        try {
            $this->response = $this->client->request($method, $this->getRoute($uri), $options);
        } catch (GuzzleException $e) {
            throw new RequestChasterException('Request failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws \ChasterApp\Exception\ResponseChasterException
     */
    protected function response(string $exceptionMessage, int $expectedStatusCode): ResponseInterface
    {
        $response = new Response($this->response);
        if ($response->getStatusCode() !== $expectedStatusCode) {
            throw new ResponseChasterException(
                $response->getReasonPhrase(),
                $response->getStatusCode(),
                'Response error -> ' . $exceptionMessage . ': response code: ' . $response->getStatusCode()
                . ' - reason: ' . $response->getReasonPhrase()
            );
        }
        return $response;
    }

    /**
     * Check if the response is successful
     * @throws InvalidArgumentChasterException
     */
    protected function checkMandatoryArgument(mixed $value, string $name): void
    {
        if (empty($value)) {
            throw new InvalidArgumentChasterException(ucfirst($name) . ' is mandatory', 400);
        }
    }
}
