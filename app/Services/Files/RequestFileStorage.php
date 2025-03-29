<?php

declare(strict_types=1);

namespace App\Services\Files;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Enums\DirectoryName;
use App\Models\File;

class RequestFileStorage
{
    public function saveFile(UploadedFile $uploadedFile, DirectoryName $directory = DirectoryName::Default): File
    {
        $fileStorage = new FileStorage(
            $uploadedFile->getRealPath(),
            $uploadedFile->getClientOriginalName(),
            $directory->value
        );

        return $fileStorage->saveFile();
    }
}
