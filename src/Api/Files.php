<?php

namespace ChasterApp\Api;

use ChasterApp\ClientOptions;
use ChasterApp\Data\Enum\StorageFileType;
use ChasterApp\Interfaces\Api\FilesInterface;
use ChasterApp\Interfaces\ClientOptionsInterface;
use ChasterApp\Interfaces\RequestBody\Files\UploadFilesInterface;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\Request;
use ChasterApp\RequestBody\Files\UploadFiles;

class Files extends Request implements FilesInterface
{


    public function getBaseRoute(): string
    {
        return 'files';
    }

    /**
     * Find a file
     * @link https://api.chaster.app/api/#/Files/StorageController_getFileFromKey
     *
     * @param string $fileKey Mandatory. The file key.
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     *
     * @throws \ChasterApp\Exception\ResponseChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function find(string $fileKey): ResponseInterface
    {
        $this->checkMandatoryArgument($fileKey, 'File key');
        $this->getClient('/' . $fileKey);
        return $this->response(201);
    }

    /**
     * Upload attachments and get an attachment token to be used in messaging and posts
     * The attachment token expires after one hour.
     * @link https://api.chaster.app/api/#/Files/StorageController_uploadFiles
     *
     * @param array|\ChasterApp\RequestBody\Files\UploadFiles $files
     * @param string|\ChasterApp\Data\Enum\StorageFileType $type
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     * @throws \ChasterApp\Exception\ResponseChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     */
    public function upload(
        UploadFiles|array $files,
        StorageFileType|string $type = StorageFileType::messaging
    ): ResponseInterface {
        $this->checkMandatoryArgument($files->getArrayCopy(), 'Files to upload');
        $this->checkMandatoryArgument($type, 'Target storage');
        if ($type instanceof StorageFileType) {
            $type = $type->value;
        }

        $multipart = new ClientOptions();
        $multipart->setMultipartValue('type', $type);
        foreach ($files as $file) {
            $temp = [...$multipart->getMultipartValue('files'), $file];
            $multipart->setMultipartValue('files', $temp);
        }

        $this->postClient('/upload', options: $multipart);
        return $this->response(201);
    }

    private function setUploadFiles(UploadFilesInterface|array $files, ClientOptionsInterface|array $options): array
    {
        return [];
    }
}
