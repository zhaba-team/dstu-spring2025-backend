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

        Race::query()
            ->orderByDesc('id')
            ->limit($numberOfRaces)
            ->get();

        $statistics = [];
        foreach ($members as $member) {
            $statistic = [
                'id' => $member->id,
                'color' => $member->color,
            ];

            for ($i = 1; $i < $placesCount + 1; ++$i) {
                $won = $member
                    ->races()
                    ->where('place', $i)
                    ->count();

                $statistic[strval($i)] = $won / $numberOfRaces;
            }

            $statistics[] = $statistic;
        }

        return $statistics;
    }
}
