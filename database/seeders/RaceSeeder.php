<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Race;
use App\Services\Race\RaceService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Random\RandomException;

class RaceSeeder extends Seeder
{
    /**
     * @throws RandomException
     */
    public function run(): void
    {
        $timeNow = Carbon::now()->format('H:i:s');
        $raceService = new RaceService($timeNow);

        $numberOfRaces = config('settings.number_of_races');
        $members = Member::all();

        for ($i = 0; $i < $numberOfRaces; ++$i) {
            $places = range(1, $members->count());
            $race = Race::query()->create();

            $timings = [];
            foreach ($members as $member) {
                $timings[$member->id] = $raceService->getRiceTime($member);
            }

            asort($timings); // сортируем по возрастанию
            foreach ($members as $member) {
                $keys = array_keys($timings);
                $place = array_search($member->id, $keys) + 1;

                $race->members()->attach(
                    $member->id,
                    [
                        'place' => $place,
                    ]
                );

                $places = array_diff($places, [$place]);
            }
        }
    }
}
