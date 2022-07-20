<?php

namespace Api;

use ChasterApp\Api\Conversations;
use ChasterApp\Api\Files;
use ChasterApp\Data\Enum\ConversationsStatus;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase {

    protected function setUp(): void
    {
//        $this->files = Mockery::mock(Files::class)->makePartial();
        $this->files = new Files('mock_token');
        $reflection = new \ReflectionClass(Files::class);
        $this->clientProperty = $reflection->getProperty('client');
        parent::setUp();
    }

    protected function setClientProperty(MockHandler $mockHandler): void
    {
        $this->clientProperty->setValue($this->files, new Client([
            'handler' => HandlerStack::create($mockHandler)
        ]));
    }

    public function testFindSuccess(): void
    {
        $mock = new MockHandler([
            new Response(201, [], '{"body": "mock_value"}'),
        ]);

        $this->setClientProperty($mock);

        try {
            $responseOne = $this->files->find(fileKey: 'mock_file_key');
        } catch (InvalidArgumentChasterException|RequestChasterException|ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
        $this->assertSame('/files', $this->files->getRoute());
        $this->assertEquals(201, $responseOne->getStatusCode());
        $this->assertEquals((object) ['body' => 'mock_value'], $responseOne->getBodyObject());
    }

    public function testFindInvalidArgumentException(): void
    {
        $this->expectException(\ChasterApp\Exception\InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('File key is mandatory, can\'t be empty');
        try {
            $this->files->find(fileKey: '');
        } catch (RequestChasterException|ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testFindRequestException(): void
    {
        $mock = new MockHandler([
            new RequestException(
                'Unauthorized mock',
                new Request('GET', '/files'),
                new Response(401, reason: 'Unauthorized mock')
            ),
        ]);

        $this->setClientProperty($mock);
        $this->expectException(\ChasterApp\Exception\RequestChasterException::class);
        $this->expectExceptionCode(401);
        $this->expectExceptionMessage('Request failed: Unauthorized mock - /files/mock_file_key');
        try {
            $this->files->find(fileKey: 'mock_file_key');
        } catch (InvalidArgumentChasterException|ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testFindResponseException(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '{"body": "mock_value"}'),
        ]);

        $this->setClientProperty($mock);
        $this->expectException(\ChasterApp\Exception\ResponseChasterException::class);
        $this->expectExceptionCode(200);
        $this->expectExceptionMessage('HTTP Code Expected: 201 Actual: 200 Reason: OK');
        try {
            $this->files->find(fileKey: 'mock_file_key');
        } catch (InvalidArgumentChasterException|RequestChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testUpload()
    {
        $this->assertTrue(true);
    }

}
