<?php

namespace Tests\ChasterApp\Api;

use ChasterApp\Api\Files;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\JsonChasterException;
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

    public function testFindSuccess(): void
    {
        $mock = new MockHandler([
            new Response(201, [], '{"body": "mock_value"}'),
        ]);

        $this->setClientProperty($mock);

        try {
            $response = $this->files->find(fileKey: 'mock_file_key');
        } catch (
            InvalidArgumentChasterException | RequestChasterException | ResponseChasterException | JsonChasterException
            $e
        ) {
            $this->fail($e->getMessage());
        }
        $this->assertSame('/files', $this->files->getRoute());
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals((object)['body' => 'mock_value'], $response->getBodyObject());
    }

    protected function setClientProperty(MockHandler $mockHandler): void
    {
        $this->clientProperty->setValue(
            $this->files,
            new Client([
                'handler' => HandlerStack::create($mockHandler)
            ])
        );
    }

    public function testFindInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('File key is mandatory, can\'t be empty');
        try {
            $this->files->find(fileKey: '');
        } catch (RequestChasterException | ResponseChasterException | JsonChasterException $e) {
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
        } catch (InvalidArgumentChasterException | ResponseChasterException | JsonChasterException $e) {
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
        } catch (InvalidArgumentChasterException | RequestChasterException | JsonChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testUploadEmptyStorageFileTypeInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Storage file type is mandatory, can\'t be empty');
        try {
            $this->files->upload(
                files: ['mock_only_for_required_argument'],
                type: ''
            );
        } catch (RequestChasterException | ResponseChasterException | JsonChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @dataProvider uploadEmptyFilesInvalidArgumentExceptionProvider
     *
     * @param $files
     * @return void
     */
    public function testUploadEmptyFilesInvalidArgumentException($files): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Files is mandatory, can\'t be empty');
        try {
            $this->files->upload(files: $files);
        } catch (RequestChasterException | ResponseChasterException | JsonChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    #[ArrayShape([
        'empty array' => "array[]",
        'empty UploadFiles' => "\ChasterApp\RequestBody\Files\UploadFiles[]"
    ])] public function uploadEmptyFilesInvalidArgumentExceptionProvider(): array
    {
        return [
            'empty array' => [
                [],
            ],
            'empty UploadFiles' => [
                new UploadFiles()
            ],
        ];
    }

    /**
     * @dataProvider providerTestUploadInvalidFileOfFilesInvalidArgumentException
     */
    public function testUploadInvalidFileOfArrayFilesInvalidArgumentException(array $files): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('File must be an array with name, contents and filename');
        try {
            $this->files->upload(files: $files);
        } catch (RequestChasterException | ResponseChasterException | JsonChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    #[ArrayShape([
        'empty file' => "array[]",
        'invalid typing file' => "string",
        'invalid key of file array' => "\string[][]"
    ])] public function providerTestUploadInvalidFileOfFilesInvalidArgumentException(): array
    {
        return [
            'empty file' => [
                [
                    [
                        'name' => 'mock_file_name',
                        'contents' => 'mock_file_content',
                        'filename' => 'mock_file_filename',
                    ],
                    []
                ],
            ],
            'invalid typing file' => [
                [
                    'name' => 'mock_file_name',
                    'contents' => 'mock_file_content',
                    'filename' => 'mock_file_filename',
                ],
                [
                    'mock_string_file'
                ]
            ],
            'invalid key of file array' => [
                [
                    'name' => 'mock_file_name',
                    'contents' => 'mock_file_content',
                    'filename' => 'mock_file_filename',
                ],
                [
                    'wrong_key' => 'mock_file_name',
                    'contents' => 'mock_file_content',
                    'filename' => 'mock_file_filename',
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerTestUploadSuccess
     */
    public function testUploadSuccess(array|UploadFilesInterface $files): void
    {
        $mock = new MockHandler([
            new Response(201, [], '{"body": "mock_value"}'),
        ]);
        $this->setClientProperty($mock);

        try {
            $response = $this->files->upload($files);
        } catch (
            InvalidArgumentChasterException | RequestChasterException | ResponseChasterException | JsonChasterException
            $e
        ) {
            $this->fail($e->getMessage());
        }
        $this->assertSame('/files', $this->files->getRoute());
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals((object)['body' => 'mock_value'], $response->getBodyObject());
    }

    #[ArrayShape([
        'array 1 file' => "\string[][][]",
        'array 3 files' => "\string[][]",
        'UploadFiles 1 file' => "\ChasterApp\RequestBody\Files\UploadFiles[]",
        'UploadFiles 3 files' => "\ChasterApp\RequestBody\Files\UploadFiles[]"
    ])] public function providerTestUploadSuccess(): array
    {
        return [
            'array 1 file' => [
                [
                    [
                        'name' => 'mock_file_name',
                        'contents' => 'mock_file_content',
                        'filename' => 'mock_file_filename',
                    ],
                ],
            ],
            'array 3 files' => [
                [
                    [
                        'name' => 'mock_file_name_1',
                        'contents' => 'mock_file_content_1',
                        'filename' => 'mock_file_filename_1',
                    ],
                    [
                        'name' => 'mock_file_nam_2e',
                        'contents' => 'mock_file_content_2',
                        'filename' => 'mock_file_filename_2',
                    ],
                    [
                        'name' => 'mock_file_name_3',
                        'contents' => 'mock_file_content_3',
                        'filename' => 'mock_file_filename_3',
                    ],
                ]
            ],
            'UploadFiles 1 file' => [
                new UploadFiles([
                    [
                        'name' => 'mock_file_name',
                        'contents' => 'mock_file_content',
                        'filename' => 'mock_file_filename',
                    ]
                ])
            ],
            'UploadFiles 3 files' => [
                new UploadFiles([
                    [
                        'name' => 'mock_file_name_1',
                        'contents' => 'mock_file_content_1',
                        'filename' => 'mock_file_filename_1',
                    ],
                    [
                        'name' => 'mock_file_nam_2e',
                        'contents' => 'mock_file_content_2',
                        'filename' => 'mock_file_filename_2',
                    ],
                    [
                        'name' => 'mock_file_name_3',
                        'contents' => 'mock_file_content_3',
                        'filename' => 'mock_file_filename_3',
                    ]
                ]),
            ],
        ];
    }
}
