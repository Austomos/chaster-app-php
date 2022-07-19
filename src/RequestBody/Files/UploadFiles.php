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
        try {
            $this->append([
                'name' => 'files',
                'contents' => Psr7\Utils::tryFopen($path, 'r'),
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            throw new InvalidArgumentChasterException('File could not be read', 500, $e);
        }
    }

    public function setFiles(UploadFilesInterface $files): void
    {
        $this->exchangeArray($files->getArrayCopy());
    }

    public function getFiles(): array
    {
        return $this->getArrayCopy();
    }

}
