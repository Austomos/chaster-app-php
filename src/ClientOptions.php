<?php

namespace ChasterApp;

use ChasterApp\Interfaces\ClientOptionsInterface;
use ArrayObject;
use JetBrains\PhpStorm\ArrayShape;

class ClientOptions extends ArrayObject implements ClientOptionsInterface
{
    private ArrayObject $json;
    private ArrayObject $query;

    public function __construct(array $json = [], array $query = [])
    {
        $this->json = new ArrayObject($json);
        $this->query = new ArrayObject($query);
        parent::__construct();
    }

    public function setQueryValue(string $key, mixed $value): void
    {
        $this->query->offsetSet($key, $value);
    }

    public function getQuery(): array
    {
        return $this->query->getArrayCopy();
    }

    public function setQuery(array $query): void
    {
        $this->query->exchangeArray($query);
    }

    public function getQueryValue(string $key): mixed
    {
        return $this->query->offsetGet($key);
    }

    public function hasQueryValue(string $key): bool
    {
        return $this->query->offsetExists($key);
    }

    public function removeQueryValue(string $key): void
    {
        $this->query->offsetUnset($key);
    }

    public function clearQuery(): void
    {
        $this->query->exchangeArray([]);
    }

    public function getJson(): array
    {
        return $this->json->getArrayCopy();
    }

    public function setJson(array $json): void
    {
        $this->json->exchangeArray($json);
    }

    public function getJsonValue(string $key): mixed
    {
        return $this->json->offsetGet($key);
    }

    public function hasJsonValue(string $key): bool
    {
        return $this->json->offsetExists($key);
    }

    public function removeJsonValue(string $key): void
    {
        $this->json->offsetUnset($key);
    }

    public function clearJson(): void
    {
        $this->json->exchangeArray([]);
    }

    public function setJsonValue(string $key, mixed $value): void
    {
        $this->json->offsetSet($key, $value);
    }

    #[ArrayShape(['json' => "array", 'query' => "array"])] public function getOptions(): array
    {
        return [
            'json' => $this->json->getArrayCopy(),
            'query' => $this->query->getArrayCopy(),
        ];
    }
}
