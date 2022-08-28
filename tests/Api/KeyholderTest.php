<?php

namespace Tests\ChasterApp\Api;

use ChasterApp\Api\Keyholder;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use ReflectionException;
use Tests\ChasterApp\TestCase;

class KeyholderTest extends TestCase
{
    protected function setUp(): void
    {
        $this->keyholder = new Keyholder('mock_token');
        parent::setUp();
    }

    public function testGetBaseRouteSuccess(): void
    {
        $this->assertEquals('keyholder', $this->keyholder->getBaseRoute());
    }

    public function testSearchSuccess(): void
    {
        $mock = new MockHandler([
            new Response(201, ['Content-Type' => 'application/json'], '{"body": "mock_value"}'),
        ]);

        try {
            $this->setClientProperty($this->keyholder, $mock);
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }

        try {
            $response = $this->keyholder->search(body: ['mock_key' => 'mock_value']);
        } catch (
            InvalidArgumentChasterException | RequestChasterException | ResponseChasterException | JsonChasterException
            $e
        ) {
            $this->fail($e->getMessage());
        }
        $this->assertSame('/keyholder', $this->keyholder->getRoute());
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals((object) ['body' => 'mock_value'], $response->getBodyObject());
    }

    public function testSearchEmptyBodyInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Body is mandatory, can\'t be empty');
        try {
            $this->keyholder->search([]);
        } catch (RequestChasterException | ResponseChasterException | JsonChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    protected function getReflectionClass(): string
    {
        return Keyholder::class;
    }
}
