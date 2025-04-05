<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\Race\RaceInformationDTO;
use App\DTO\Race\RaceMembersDTO;
use App\Enums\KeyCache;
use App\Models\Member;
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
        $arrayRaceMembers = [];

        $members = Member::all();

        $time = Carbon::now()->format('H:i:s');

        foreach ($members as $member) {
            $raceTime = random_int(10, 15);

            $arrayRaceMembers[] = new RaceMembersDTO($member->color, $raceTime);
        }

        $raceInformation = new RaceInformationDTO($time, $arrayRaceMembers);

        $key = KeyCache::CurrentRace->value;

        $currentRace = Cache::get($key);

        if ($currentRace === null) {
            Cache::put($key, $raceInformation);
        }
    }
}
