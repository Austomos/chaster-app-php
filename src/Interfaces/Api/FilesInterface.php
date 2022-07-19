<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\StorageFileType;
use ChasterApp\Interfaces\RequestBody\Files\UploadFilesInterface;
use ChasterApp\Interfaces\ResponseInterface;

interface FilesInterface
{

    /**
     * Find a file
     * @link https://api.chaster.app/api/#/Files/StorageController_getFileFromKey
     *
     * @param string $fileKey Mandatory. The file key.
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function find(string $fileKey): ResponseInterface;

    /**
     * Upload attachments and get an attachment token to be used in messaging and posts
     * The attachment token expires after one hour.
     * @link https://api.chaster.app/api/#/Files/StorageController_uploadFiles
     *
     * @param \ChasterApp\Interfaces\RequestBody\Files\UploadFilesInterface|array $files Mandatory. The files to upload.
     * @param string|\ChasterApp\Data\Enum\StorageFileType $type Mandatory. The target storage
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function upload(
        array|UploadFilesInterface $files,
        string|StorageFileType $type = StorageFileType::messaging
    ): ResponseInterface;
}
