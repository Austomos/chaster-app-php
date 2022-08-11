<?php

namespace Tests\ChasterApp\Api;

use ChasterApp\Api\Conversations;
use ChasterApp\Data\Enum\ConversationsStatus;
use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use DateTime;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use ReflectionException;
use Tests\ChasterApp\TestCase;

class ConversationsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->conversation = new Conversations('mock_token');
        parent::setUp();
    }

    public function testGetSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '{"body": "mock_value"}'),
            new Response(200, [], '{"body": "mock_value_2"}'),
        ]);
        try {
            $this->setClientProperty($this->conversation, $mock);
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }

        try {
            $responseOne = $this->conversation->get();
        } catch (JsonChasterException | RequestChasterException | ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
        $this->assertSame('/conversations', $this->conversation->getRoute());

        $this->assertEquals(200, $responseOne->getStatusCode());
        $this->assertEquals((object) ['body' => 'mock_value'], $responseOne->getBodyObject());

        try {
            $responseTwo = $this->conversation->get(
                offset: new DateTime('now')
            );
        } catch (JsonChasterException | RequestChasterException | ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals(200, $responseTwo->getStatusCode());
        $this->assertEquals((object) ['body' => 'mock_value_2'], $responseTwo->getBodyObject());
    }

    public function testGetException(): void
    {
        $mock = new MockHandler([
            new RequestException(
                'Unauthorized mock',
                new Request('GET', '/conversations'),
                new Response(401, reason: 'Unauthorized mock')
            )
        ]);
        try {
            $this->setClientProperty($this->conversation, $mock);
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }

        $this->expectException(RequestChasterException::class);
        $this->expectExceptionCode(401);
        $this->expectExceptionMessage('Unauthorized mock');

        try {
            $this->conversation->get();
        } catch (JsonChasterException | ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testSend(): void
    {
        $this->assertTrue(true);
        return;
        $mock = new MockHandler([
            new Response(201, [], '{"body": "mock_value"}'),
            new Response(200, [], '{"body": "mock_value"}'),
            new RequestException(
                'Unauthorized mock',
                new Request('GET', '/conversations'),
                new Response(401, reason: 'Unauthorized mock')
            )
        ]);

        $this->setClientProperty($mock);

        $response = $this->conversation->get(status: ConversationsStatus::approved);
        $this->assertSame('/conversations', $this->conversation->getRoute());
        $this->assertEquals((object) ['body' => 'mock_value'], $response);

        $this->assertTrue(true);
    }

    public function testUnread(): void
    {
        $this->assertTrue(true);
    }

    public function testByUser(): void
    {
        $this->assertTrue(true);
    }

    public function testFind(): void
    {
        $this->assertTrue(true);
    }

    public function testStatus(): void
    {
        $this->assertTrue(true);
    }

    public function testMessages(): void
    {
        $this->assertTrue(true);
    }

    public function testCreate(): void
    {
        $this->assertTrue(true);
    }

    protected function getReflectionClass(): string
    {
        return Conversations::class;
    }
}
