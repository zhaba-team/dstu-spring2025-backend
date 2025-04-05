<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Race;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfRaces = config('settings.number_of_races');
        $members = Member::all();

        for ($i = 0; $i < $numberOfRaces; ++$i) {
            $places = range(1, $members->count());
            $race = Race::query()->create();

            foreach ($members as $member) {
                $place = $places[array_rand($places)];

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
