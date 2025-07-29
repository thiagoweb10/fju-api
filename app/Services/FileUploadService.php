<?php

namespace App\Services;

use App\Contracts\FileUploadServiceInterface;
use Illuminate\Http\UploadedFile;

class FileUploadService implements FileUploadServiceInterface
{
    public function upload(UploadedFile $file, string $path): string
    {
        return $file->store($path, 'public');
    }
}
