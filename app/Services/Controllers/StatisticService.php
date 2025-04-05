<?php

declare(strict_types=1);

namespace App\Services\Controllers;

use App\Models\Member;
use App\Models\Race;

class StatisticService
{
    /**
     * @return mixed[]
     */
    public function collect(): array
    {
        /** @var integer $numberOfRaces */
        $numberOfRaces = config('settings.number_of_races');
        /** @var integer $placesCount */
        $placesCount = config('settings.number_of_members');

        $members = Member::all();

        $latestRaceIds = Race::query()
            ->latest('id')
            ->limit($numberOfRaces)
            ->pluck('id');

        $statistics = [];
        foreach ($members as $member) {
            $statistic = [
                'number' => $member->number,
                'color' => $member->color,
            ];

            for ($i = 1; $i < $placesCount + 1; ++$i) {
                $won = $member
                    ->races()
                    ->whereIn('race_id', $latestRaceIds)
                    ->where('place', $i)
                    ->count();

                $statistic[strval($i)] = $won / $numberOfRaces;
            }

            $statistic['topTwo'] = $statistic['1'] + $statistic['2'];
            $statistic['topThree'] = $statistic['topTwo'] + $statistic['3'];

            $statistics[] = $statistic;
        }

        return $statistics;
    }
}
