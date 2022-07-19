<?php

namespace ChasterApp\Api;

use ChasterApp\ClientOptions;
use ChasterApp\Data\Enum\StorageFileType;
use ChasterApp\Interfaces\Api\FilesInterface;
use ChasterApp\Interfaces\RequestBody\Files\UploadFilesInterface;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\Request;

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
        $this->isNotEmptyMandatoryArgument($fileKey, 'File key');
        $this->getClient('/' . $fileKey);
        return $this->response(201);
    }

    /**
     * Upload attachments and get an attachment token to be used in messaging and posts
     * The attachment token expires after one hour.
     * @link https://api.chaster.app/api/#/Files/StorageController_uploadFiles
     *
     * @param \ChasterApp\Interfaces\RequestBody\Files\UploadFilesInterface|array $files Mandatory. The files to upload.
     * @param string|\ChasterApp\Data\Enum\StorageFileType $type Mandatory. The target storage
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     *
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     * @throws \ChasterApp\Exception\ResponseChasterException
     */
    public function upload(
        UploadFilesInterface|array $files,
        StorageFileType|string $type = StorageFileType::messaging
    ): ResponseInterface {
        if ($type instanceof StorageFileType) {
            $type = $type->value;
        }
        $this->isNotEmptyMandatoryArgument($type, 'Target storage');

        if ($files instanceof UploadFilesInterface) {
            $files = $files->getFiles();
        }
        $this->isNotEmptyMandatoryArgument($files, 'Files');

        $options = new ClientOptions();
        $options->setMultipartValue('type', $type);
        foreach ($files as $file) {
            $options->setMultipartValue(
                name: $file['name'],
                contents: $file['contents'],
                filename: $file['filename']
            );
        }
        $this->postClient('/upload', options: $options);
        return $this->response(201);
    }
}
