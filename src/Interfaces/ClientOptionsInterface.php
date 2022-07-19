<?php

namespace ChasterApp\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Psr\Http\Message\StreamInterface;
use Serializable;

interface ClientOptionsInterface extends IteratorAggregate, ArrayAccess, Serializable, Countable
{
    public function clearJson(): void;

    public function clearMultipart(): void;

    public function clearQuery(): void;

    public function getJson(): array;

    public function getJsonValue(string $key): mixed;

    public function getMultipart(): array;

    public function getMultipartValue(string $key): mixed;

    public function getOptions(): array;

    public function getQuery(): array;

    public function getQueryValue(string $key): mixed;

    public function hasJsonValue(string $key): bool;

    public function hasMultipartValue(string $key): bool;

    public function hasQueryValue(string $key): bool;

    public function removeJsonValue(string $key): void;

    public function removeMultipartValue(string $key): void;

    public function removeQueryValue(string $key): void;

    public function setJson(array $json): void;

    public function setJsonValue(string $key, mixed $value): void;

    public function setMultipart(array $multipart): void;

    public function setMultipartValue(string $key, mixed $value): void;

    public function setQuery(array $query): void;

    public function setQueryValue(string $key, mixed $value): void;

    public function __construct(array $json = [], array $query = [], array $multipart = []);
}
