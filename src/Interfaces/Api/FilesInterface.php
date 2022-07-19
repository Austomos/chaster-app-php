<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\StorageFileType;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\RequestBody\Files\UploadFiles;

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
     * @param array|\ChasterApp\RequestBody\Files\UploadFiles $files
     * @param string|\ChasterApp\Data\Enum\StorageFileType $type
     *
     * @return \ChasterApp\Interfaces\ResponseInterface
     */
    public function upload(
        array|UploadFiles $files,
        string|StorageFileType $type = StorageFileType::messaging
    ): ResponseInterface;
}
