<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\Race\RaceInformationDTO;
use App\Enums\KeyCache;
use App\Events\OnlineRace;
use App\Services\Race\RunnerService;
use Carbon\Carbon;
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
        $timeNow = Carbon::now()->format('H:i:s');

        $key = KeyCache::CurrentRace->value;

        /** @var ?RaceInformationDTO $currentRace */
        $currentRace = Cache::get($key);

        foreach ((array) $currentRace?->members as $race) {
            $runnerService = new RunnerService($race);

            $timestamp1 = strtotime((string) $currentRace?->time);
            $timestamp2 = strtotime($timeNow);

            $difference = abs($timestamp1 - $timestamp2);

            $race->raceTime = $runnerService->calculateTimeRaceFined($difference);
        }

        OnlineRace::dispatch($currentRace);
    }
}
