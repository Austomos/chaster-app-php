<?php

namespace Tests\ChasterApp;

use ChasterApp\ChasterApp;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Interfaces\Api\FilesInterface;
use PHPUnit\Framework\TestCase;

class ChasterAppTest extends TestCase
{

    public function testTokenSetterSuccess(): void
    {
        $token = 'mock_token';
        try {
            $chasterApp = new ChasterApp($token);
            $this->assertEquals($token, $chasterApp->token());
        } catch (InvalidArgumentChasterException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testTokenSetterEmptyInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Access token or developer token is required');
        new ChasterApp('');
    }
}
