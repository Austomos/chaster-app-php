<?php

namespace Tests\ChasterApp\Api;

use ChasterApp\Api\Files;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use ChasterApp\Interfaces\RequestBody\Files\UploadFilesInterface;
use ChasterApp\RequestBody\Files\UploadFiles;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class FilesTest extends TestCase
{

    protected function setUp(): void
    {
        $this->files = new Files('mock_token');
        $reflection = new ReflectionClass(Files::class);
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
        $this->expectException(InvalidArgumentChasterException::class);
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
        $this->expectException(RequestChasterException::class);
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
        $this->expectException(ResponseChasterException::class);
        $this->expectExceptionCode(200);
        $this->expectExceptionMessage('HTTP Code Expected: 201 Actual: 200 Reason: OK');
        try {
            $this->files->find(fileKey: 'mock_file_key');
        } catch (InvalidArgumentChasterException|RequestChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testUploadStorageFileTypeInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Target storage is mandatory, can\'t be empty');
        try {
            $this->files->upload([], '');
        } catch (RequestChasterException|ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testUploadEmptyFilesInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Files is mandatory, can\'t be empty');
        try {
            $this->files->upload([], 'mock_target_storage_type');
        } catch (RequestChasterException|ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
    }
}
