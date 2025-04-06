<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Enums\KeyCache;
use App\Models\Race;

class RaceObserver
{
    /**
     * Handle the file "created" event.
     */
    public function created(Race $race): void
    {
        Cache::forget(KeyCache::Statistic->value);
    }

    /**
     * Handle the file "updated" event.
     */
    public function updated(Race $race): void
    {
        Cache::forget(KeyCache::Statistic->value);
    }

    /**
     * Handle the file "deleted" event.
     */
    public function deleted(Race $race): void
    {
        Cache::forget(KeyCache::Statistic->value);
    }

    /**
     * Handle the file "restored" event.
     */
    public function restored(Race $race): void
    {
    }

    /**
     * Handle the file "force deleted" event.
     */
    public function forceDeleted(Race $race): void
    {
    }
}
