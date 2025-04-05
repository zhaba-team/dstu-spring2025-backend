<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\Race\RaceInformationDTO;
use App\Enums\KeyCache;
use App\Events\OnlineRace;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GetCurrentLocationRunners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:current-location-runners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Показывает текущие положение бегунов';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $key = KeyCache::CurrentRace->value;

        /** @var ?RaceInformationDTO $currentRace */
        $currentRace = Cache::get($key);

        OnlineRace::dispatch($currentRace);
    }
}
