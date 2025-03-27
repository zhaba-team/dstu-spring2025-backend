<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileObserver
{
    /**
     * Handle the file "created" event.
     */
    public function created(File $file): void
    {
    }

    /**
     * Handle the file "updated" event.
     */
    public function updated(File $file): void
    {
    }

    /**
     * Handle the file "deleted" event.
     */
    public function deleted(File $file): void
    {
        // Удаляем файл из файловой системы
        Storage::disk($file->storage)->delete($file->path);
    }

    /**
     * Handle the file "restored" event.
     */
    public function restored(File $file): void
    {
    }

    /**
     * Handle the file "force deleted" event.
     */
    public function forceDeleted(File $file): void
    {
    }
}
