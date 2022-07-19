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

    public function getOptions(): array;

    public function getQuery(): array;

    public function getQueryValue(string $key): mixed;

    public function hasJsonValue(string $key): bool;

    public function hasQueryValue(string $key): bool;

    public function removeJsonValue(string $key): void;

    public function removeQueryValue(string $key): void;

    public function setJson(array $json): void;

    public function setJsonValue(string $key, mixed $value): void;

    public function setMultipart(array $multipart): void;

    /**
     * Multipart for guzzle
     * @link https://docs.guzzlephp.org/en/stable/request-options.html#multipart
     *
     * @param $name: (string, required) the form field name
     * @param $contents: (StreamInterface/resource/string, required) The data to use in the form element.
     * @param $headers: (array) Optional associative array of custom headers to use with the form element.
     * @param $filename: (string) Optional string to send as the filename in the part.
     *
     * @return void
     */
    public function setMultipartValue(
        string $name,
        StreamInterface|string $contents,
        array $headers = [],
        string $filename = null
    ): void;

    public function setQuery(array $query): void;

    public function setQueryValue(string $key, mixed $value): void;

    public function __construct(array $json = [], array $query = [], array $multipart = []);
}
