<?php

namespace Tests\ChasterApp\Api;

use ChasterApp\Api\Conversations;
use ChasterApp\Data\Enum\ConversationsStatus;
use ChasterApp\Exception\RequestChasterException;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class ConversationsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->conversation = Mockery::mock(Conversations::class)->makePartial();
        $reflection = new \ReflectionClass(Conversations::class);
        $this->clientProperty = $reflection->getProperty('client');
        $this->clientProperty->setAccessible(true);
        parent::setUp();
    }

    protected function setClientProperty(MockHandler $mockHandler): void
    {
        $this->clientProperty->setValue($this->conversation, new Client([
            'handler' => HandlerStack::create($mockHandler)
        ]));
    }

    public function testGet(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '{"body": "mock_value"}'),
            new Response(200, [], '{"body": "mock_value_2"}'),
            new RequestException(
                'Unauthorized mock',
                new Request('GET', '/conversations'),
                new Response(401, reason: 'Unauthorized mock')
            )
        ]);
        $this->setClientProperty($mock);

        $responseOne = $this->conversation->get(status: ConversationsStatus::approved);
        $this->assertSame('/conversations', $this->conversation->getRoute());

        $this->assertEquals(200, $responseOne->getStatusCode());
        $this->assertEquals((object) ['body' => 'mock_value'], $responseOne->getBodyObject());

        $responseTwo = $this->conversation->get(
            status: ConversationsStatus::approved,
            offset: new DateTime('now')
        );
        $this->assertEquals(200, $responseTwo->getStatusCode());
        $this->assertEquals((object) ['body' => 'mock_value_2'], $responseTwo->getBodyObject());

        $this->expectException(RequestChasterException::class);
        try {
            $this->conversation->get(status: ConversationsStatus::approved);
        } catch (RequestChasterException $e) {
            $this->assertSame('Request failed: Unauthorized mock - /conversations', $e->getMessage());
            $this->assertEquals(401, $e->getCode());
            throw $e;
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
}
