<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface FileUploadServiceInterface
{
    public function upload(UploadedFile $file, string $path): string;
}
