<?php

namespace Tests\ChasterApp\Api;

use ChasterApp\Api\Locks;
use ChasterApp\Exception\ChasterException;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use ChasterApp\RequestBody\Locks\LockHistory;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use ReflectionException;
use Tests\ChasterApp\TestCase;

class LocksTest extends TestCase
{
    protected function setUp(): void
    {
        $this->locks = new Locks('mock_token');
        parent::setUp();
    }

    public function testHistorySuccess(): void
    {
        $mock = new MockHandler([
            new Response(201, ['Content-Type' => 'application/json'], '{"body": "mock_value"}'),
            new Response(201, ['Content-Type' => 'application/json'], '{"body": "mock_value"}'),
        ]);

        try {
            $this->setClientProperty($this->locks, $mock);
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }

        try {
            $response = $this->locks->history('mock_locks_id', ['mock_body']);
        } catch (ChasterException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertSame('/locks', $this->locks->getRoute());
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals((object) ['body' => 'mock_value'], $response->getBodyObject());

        $lockHistory = new LockHistory();
        $lockHistory->setExtension('mock_extension')->setLimit(10)->setLastId('mock_last_id');

        try {
            $response = $this->locks->history('mock_locks_id', ['mock_body']);
        } catch (ChasterException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals((object) ['body' => 'mock_value'], $response->getBodyObject());
    }

    public function testHistoryEmptyLockIdInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Lock ID is mandatory, can\'t be empty');
        try {
            $this->locks->history('', ['mock_body']);
        } catch (JsonChasterException | RequestChasterException | ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testHistoryEmptyArrayBodyInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Body is mandatory, can\'t be empty');
        try {
            $this->locks->history('mock_lock_id', []);
        } catch (JsonChasterException | RequestChasterException | ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testHistoryEmptyLockHistoryBodyInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Body is mandatory, can\'t be empty');
        try {
            $this->locks->history('mock_lock_id', new LockHistory());
        } catch (JsonChasterException | RequestChasterException | ResponseChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    protected function getReflectionClass(): string
    {
        return Locks::class;
    }
}
