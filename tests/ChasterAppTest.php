<?php

namespace ChasterApp\Tests;

use ChasterApp\ChasterApp;
use ChasterApp\Exception\InvalidArgumentChasterException;
use PHPUnit\Framework\TestCase;

class ChasterAppTest extends TestCase {

    public function testTokenSetterSuccess(): void
    {
        $token = 'mock_token';
        $chasterApp = new ChasterApp($token);
        $this->assertEquals($token, $chasterApp->token());
    }

    public function testTokenSetterEmptyInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentChasterException::class);
        try {
            new ChasterApp('');
        } catch (InvalidArgumentChasterException $e) {
            $this->assertEquals('Access token or developer token is required', $e->getMessage());
            throw $e;
        }
    }

}
