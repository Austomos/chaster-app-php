<?php

namespace Tests\ChasterApp;

use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testConstructSuccess(): void
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(
            200,
            ['Content-Type' => 'application/json'],
            '{"body": "mock_value"}'
        );
        try {
            $response = new Response($mockResponse);
        } catch (JsonChasterException $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetBodySuccess(): void
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(
            200,
            ['Content-Type' => 'application/json'],
            '{"body": "mock_value"}'
        );
        try {
            $response = new Response($mockResponse);
        } catch (JsonChasterException $e) {
            $this->fail($e->getMessage());
        }
        try {
            $this->assertSame(['body' => 'mock_value'], $response->getBodyArray());
//            $this->assertSame((object)['body' => 'mock_value'], $response->getBodyObject());
        } catch (JsonChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testConstructJsonException(): void
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(
            200,
            ['Content-Type' => 'application/json'],
            'mock_string'
        );
        $this->expectException(JsonChasterException::class);
        new Response($mockResponse);
    }

    public function testGetBodyArrayJsonException(): void
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(
            200,
            [],
            'mock_string'
        );
        try {
            $response = new Response($mockResponse);
        } catch (JsonChasterException $e) {
            $this->fail($e->getMessage());
        }

        $this->expectException(JsonChasterException::class);
        $response->getBodyArray();
    }

    public function testGetBodyObjectJsonException(): void
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(
            200,
            [],
            'mock_string'
        );
        try {
            $response = new Response($mockResponse);
        } catch (JsonChasterException $e) {
            $this->fail($e->getMessage());
        }

        $this->expectException(JsonChasterException::class);
        $response->getBodyObject();
    }
}
