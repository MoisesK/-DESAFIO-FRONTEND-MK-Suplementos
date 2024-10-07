<?php

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;

class CloudinaryStorageApi
{
    private Configuration $config;

    public function __construct()
    {
        $key = env('CLOUDINARY_KEY');
        $secret = env('CLOUDINARY_SECRET');
        $cloudName = env('CLOUDINARY_CLOUD_NAME');

        $this->config = Configuration::instance("cloudinary://{$key}:{$secret}@{$cloudName}?secure=true");
    }

    public function upload(UploadedFile $file, string $folder, ?string $fileName = null): string
    {
        $cloudinary = new UploadApi($this->config);
        $fileUploaded = $cloudinary->upload($file->getRealPath(), [
            'unique_filename' => false,
            'public_id' => 'comprovante_de_pagamento',
            'folder' => $folder
        ]);

        return $fileUploaded->getArrayCopy()['url'];
    }
}
