<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\KeyCache;
use App\Services\Race\RaceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Random\RandomException;

class UpdateStatisticAndStartRace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'race:update-and-start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет статистику и запускает новый забег';

    /**
     * Execute the console command.
     *
     * @throws RandomException
     */
    public function handle(): void
    {
        $timeNow = Carbon::now()->format('H:i:s');

        $raceService = new RaceService($timeNow);

        $raceInformation = $raceService->getInformation();

        $key = KeyCache::CurrentRace->value;

        Cache::put($key, $raceInformation);
    }
}
