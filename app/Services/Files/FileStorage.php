<?php

declare(strict_types=1);

namespace App\Services\Files;

use Illuminate\Support\Facades\Storage;
use App\Exception\FileException;
use App\Models\File;

class FileStorage
{
    private readonly FileMeta $meta;

    public function __construct(
        public string $filePath,
        public string $originalName,
        public string $storeDirectory,
    ) {
        $this->meta = new FileMeta($this->filePath);
    }

    public function getFileExtension(): string
    {
        $extension = pathinfo($this->filePath, PATHINFO_EXTENSION);
        if (empty($extension)) {
            $extension = pathinfo($this->originalName, PATHINFO_EXTENSION);
        }
        return $extension;
    }

    /**
     * @throws FileException
     */
    public function getTargetPath(): string
    {
        $filePathBase = $this->storeDirectory === '' || $this->storeDirectory === '0' ? '' : rtrim($this->storeDirectory, '/') . '/';
        $filePath = $this->getStoragePath() . '/' . $this->meta->getMd5() . '.' . $this->getFileExtension();

        // Check file exists
        if (Storage::exists($filePathBase . $filePath)) {
            $i = 0;
            do {
                ++$i;
                $filePath = $this->getStoragePath() . '/' . $this->meta->getMd5() . '_' . $i . '.' . $this->getFileExtension();
            } while (Storage::exists($filePathBase . $filePath));
        }

        return $filePath;
    }

    /**
     * @throws FileException
     */
    public function getStoragePath(): string
    {
        $hash = $this->meta->getMd5();
        $path = mb_substr($hash, 0, 2);
        $path .= '/' . mb_substr($hash, 2, 2);

        return $path . '/' . mb_substr($hash, 4, 2);
    }

    /**
     * @throws FileException
     */
    public function saveFile(): File
    {
        $savedPath = Storage::putFileAs($this->storeDirectory, $this->filePath, $this->getTargetPath());

        return File::query()->create(
            [
                'storage' => config('filesystems.default'),
                'name'    => $this->originalName,
                'path'    => $savedPath,
                'md5'     => $this->meta->getMd5(),
                'sha1'    => $this->meta->getSha1(),
                'size'    => $this->meta->getSize(),
            ]
        );
    }
}
