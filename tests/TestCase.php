<?php

namespace Tests\ChasterApp;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use ReflectionClass;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    private ReflectionClass $reflection;

    /**
     * provide class name for reflection
     */
    abstract protected function getReflectionClass(): string;

    /**
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        $this->reflection = new ReflectionClass($this->getReflectionClass());
        parent::setUp();
    }

    /**
     * @throws \ReflectionException
     */
    protected function setClientProperty(object $object, MockHandler $mockHandler): void
    {
        $clientProperty = $this->reflection->getProperty('client');
        $clientProperty->setValue(
            $object,
            new Client([
                'handler' => HandlerStack::create($mockHandler)
            ])
        );
    }
}