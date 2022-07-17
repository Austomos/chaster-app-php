<?php

namespace ChasterApp\Interfaces;

interface ClientOptionsInterface extends \IteratorAggregate, \ArrayAccess, \Serializable, \Countable
{
    public function getOptions(): array;

    public function clearJson(): void;

    public function clearQuery(): void;

    public function getJson(): array;

    public function getJsonValue(string $key): mixed;

    public function getQuery(): array;

    public function getQueryValue(string $key): mixed;

    public function hasJsonValue(string $key): bool;

    public function hasQueryValue(string $key): bool;

    public function removeJsonValue(string $key): void;

    public function removeQueryValue(string $key): void;

    public function setJson(array $json): void;

    public function setJsonValue(string $key, mixed $value): void;

    public function setQuery(array $query): void;

    public function setQueryValue(string $key, mixed $value): void;
}
