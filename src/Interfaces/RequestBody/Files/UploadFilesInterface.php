<?php

namespace ChasterApp\Interfaces\RequestBody\Files;

use ArrayAccess;
use Countable;
use IteratorAggregate;

interface UploadFilesInterface extends ArrayAccess, Countable, IteratorAggregate
{
    public function setFile(string $path, string $filename): void;

    public function setFiles(UploadFilesInterface $files): void;

    public function getFiles(): array;
}
