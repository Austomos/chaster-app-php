<?php

namespace ChasterApp;

use ChasterApp\Interfaces\ClientOptionsInterface;
use ArrayObject;
use JetBrains\PhpStorm\ArrayShape;

class ClientOptions extends ArrayObject implements ClientOptionsInterface
{
    private ArrayObject $json;
    private ArrayObject $multipart;
    private ArrayObject $query;

    public function __construct(array $json = [], array $query = [], array $multipart = [])
    {
        $this->json = new ArrayObject($json);
        $this->query = new ArrayObject($query);
        $this->multipart = new ArrayObject($multipart);
        parent::__construct();
    }

    public function setQueryValue(string $key, mixed $value): void
    {
        $this->query->offsetSet($key, $value);
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

    #[ArrayShape([
        'json' => "array",
        'query' => "array",
        'multipart' => "array"
    ])] public function getOptions(): array
    {
        return [
            'json' => $this->getJson(),
            'query' => $this->getQuery(),
            'multipart' => $this->getMultipart(),
        ];
    }

    public function getJson(): array
    {
        return $this->json->getArrayCopy();
    }

    public function setJson(array $json): void
    {
        $this->json->exchangeArray($json);
    }

    public function getQuery(): array
    {
        return $this->query->getArrayCopy();
    }

    public function setQuery(array $query): void
    {
        $this->query->exchangeArray($query);
    }

    public function getMultipart(): array
    {
        return $this->multipart->getArrayCopy();
    }

    public function setMultipart(array $multipart): void
    {
        $this->multipart->exchangeArray($multipart);
    }

    public function clearMultipart(): void
    {
        $this->multipart->exchangeArray([]);
    }

    public function getMultipartValue(string $key): mixed
    {
        return $this->multipart->offsetGet($key);
    }

    public function hasMultipartValue(string $key): bool
    {
        return $this->multipart->offsetExists($key);
    }

    public function removeMultipartValue(string $key): void
    {
        $this->multipart->offsetUnset($key);
    }

    public function setMultipartValue(string $key, mixed $value): void
    {
        $this->multipart->offsetSet($key, $value);
    }
}
