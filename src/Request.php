<?php

namespace ChasterApp;

use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use ChasterApp\Interfaces\ClientOptionsInterface;
use ChasterApp\Interfaces\RequestInterface;
use ChasterApp\Interfaces\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class Request implements RequestInterface
{
    private const BASE_URI = 'https://api.chaster.app';
    protected Client $client;
    private \Psr\Http\Message\ResponseInterface $response;

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
     * @throws RequestChasterException
     */
    public function getClient(string $uri, ?array $query = null, array|ClientOptionsInterface $options = []): void
    {
        if (!empty($query)) {
            $options['query'] = $query;
        }
        $this->client('GET', $uri, $options);
    }

    /**
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function patchClient(string $uri, ?array $query = null, array|ClientOptionsInterface $options = []): void
    {
        $this->client('PATCH', $uri, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array|\ChasterApp\Interfaces\ClientOptionsInterface $options
     *
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function client(string $method, string $uri, array|ClientOptionsInterface $options = []): void
    {
        $route = $this->getRoute($uri);
        if ($options instanceof ClientOptionsInterface) {
            $options = $options->getOptions();
        }
        try {
            $this->response = $this->client->request($method, $route, $options);
        } catch (GuzzleException $e) {
            throw new RequestChasterException(
                'Request failed: ' . $e->getMessage() . ' - ' . $route,
                $e->getCode(),
                $e
            );
        }
    }

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
     * Provide category base route of the API
     * https://api.chaster.app/{category}
     * @example https://api.chaster.app/auth/profile
     * 'auth' is the category and 'profile' is the route
     *
     * @return string
     */
    abstract public function getBaseRoute(): string;

    /**
     * @param string $uri URI specific of the call
     * @param array|null $body Array
     * @param array|\ChasterApp\Interfaces\ClientOptionsInterface $options
     *
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function postClient(string $uri, ?array $body = null, array|ClientOptionsInterface $options = []): void
    {
        if (!empty($body)) {
            $options['json'] = $body;
        }
        $this->client('POST', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array|null $body
     * @param array|\ChasterApp\Interfaces\ClientOptionsInterface $options
     *
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function putClient(string $uri, ?array $body = null, array|ClientOptionsInterface $options = []): void
    {
        if (!empty($body)) {
            $options['json'] = $body;
        }
        $this->client('PUT', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array|null $body
     * @param array|\ChasterApp\Interfaces\ClientOptionsInterface $options
     *
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function deleteClient(string $uri, ?array $body = null, array|ClientOptionsInterface $options = []): void
    {
        if (!empty($body)) {
            $options['json'] = $body;
        }
        $this->client('DELETE', $uri, $options);
    }

    /**
     * @throws \ChasterApp\Exception\ResponseChasterException
     */
    public function response(int $expectedStatusCode): ResponseInterface
    {
        $response = new Response($this->response);
        if ($expectedStatusCode >= 100
            && $expectedStatusCode < 600
            && $response->getStatusCode() !== $expectedStatusCode
        ) {
            throw new ResponseChasterException(
                'HTTP Code Expected: ' . $expectedStatusCode
                . ' Actual: ' . $response->getStatusCode()
                . ' Reason: ' . $response->getReasonPhrase(),
                $response->getStatusCode(),
            );
        }
        return $response;
    }

    /**
     * Check if the response is successful
     * @throws InvalidArgumentChasterException
     */
    public function checkMandatoryArgument(mixed $value, string $name): void
    {
        if (empty($value)) {
            throw new InvalidArgumentChasterException(ucfirst($name) . ' is mandatory', 400);
        }
    }

    /**
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function isNotEmptyMandatoryArgument(mixed $value, string $name): bool
    {
        if (empty($value)) {
            throw new InvalidArgumentChasterException(ucfirst($name) . ' is mandatory, can\'t be empty', 400);
        }
        return true;
    }

    /**
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function issetMandatoryArgument(mixed $value, string $name): bool
    {
        if (empty($value)) {
            throw new InvalidArgumentChasterException(ucfirst($name) . ' is mandatory', 400);
        }
        return true;
    }
}
