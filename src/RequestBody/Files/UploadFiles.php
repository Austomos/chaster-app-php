<?php

namespace ChasterApp\RequestBody\Files;

use ArrayObject;
use GuzzleHttp\Psr7;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Interfaces\RequestBody\Files\UploadFilesInterface;

class UploadFiles extends ArrayObject implements UploadFilesInterface
{

    /**
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function setFile(string $path, string $filename): void
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentChasterException('File does not exist', 404);
        }
        if (empty($filename)) {
            throw new InvalidArgumentChasterException('File name is empty', 400);
        }
        $this->offsetSet($filename, [
            'name' => 'files',
            'contents' => Psr7\Utils::tryFopen($path, 'r'),
            'filename' => $filename,
        ]);
    }

    public function removeFile(string $filename): void
    {
        $this->offsetUnset($filename);
    }

    public function setFiles(UploadFilesInterface $files): void
    {
        $this->exchangeArray($files->getArrayCopy());
    }
}
