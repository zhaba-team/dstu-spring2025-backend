<?php

declare(strict_types=1);

namespace App\Services\Files;

use App\Exception\FileException;

class FileMeta
{
    private string $sha1 = '';
    private string $md5 = '';

    public function __construct(
        public string $filePath
    ) {
    }

    /**
     * @throws FileException
     */
    public function getSha1(): string
    {
        if ($this->sha1 !== '' && $this->sha1 !== '0') {
            return $this->sha1;
        }
        $hash = sha1_file($this->filePath);
        if ($hash === false) {
            throw new FileException('Could not get sha1 hash for file ' . $this->filePath);
        }
        $this->sha1 = $hash;
        return $this->sha1;
    }

    /**
     * @throws FileException
     */
    public function getMd5(): string
    {
        if ($this->md5 !== '' && $this->md5 !== '0') {
            return $this->md5;
        }

        $hash = md5_file($this->filePath);
        if ($hash === false) {
            throw new FileException('Could not get md5 hash for file ' . $this->filePath);
        }
        $this->md5 = $hash;
        return $this->md5;
    }

    /**
     * @throws FileException
     */
    public function getSize(): int
    {
        $filesize = filesize($this->filePath);
        if ($filesize === false) {
            throw new FileException('Could not get size of file ' . $this->filePath);
        }
        return $filesize;
    }
}
