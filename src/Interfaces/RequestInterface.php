<?php

namespace ChasterApp\Interfaces;

interface RequestInterface
{
    public function getClient(string $uri, array|ClientOptionsInterface $options = []): void;
    public function postClient(string $uri, array|ClientOptionsInterface $options = []): void;
    public function putClient(string $uri, array|ClientOptionsInterface $options = []): void;
    public function deleteClient(string $uri, array|ClientOptionsInterface $options = []): void;
    public function patchClient(string $uri, array|ClientOptionsInterface $options = []): void;
    public function client(string $method, string $uri, array|ClientOptionsInterface $options = []): void;

    public function getBaseRoute(): string;
    public function getRoute(): string;

    public function issetMandatoryArgument(mixed $value, string $name): bool;
    public function isNotEmptyMandatoryArgument(mixed $value, string $name): bool;
}
