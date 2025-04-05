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

        $statistics = [];

        /** @var integer[] $latestRaceIds */
        $latestRaceIds = Race::query()
            ->latest('id')
            ->limit($numberOfRaces)
            ->pluck('id')
            ->toArray();

        $statistics['places_order'] = $this->getPlacesOrder($latestRaceIds);
        $statistics['single_probabilities'] = $this->getSingleProbabilities($latestRaceIds);

        return $statistics;
    }

    /**
     * @param integer[] $latestRaceIds
     *
     * @return mixed[]
     */
    private function getSingleProbabilities(array $latestRaceIds): array
    {
        /** @var integer $placesCount */
        $placesCount = config('settings.number_of_members');
        $members = Member::all();

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

                $statistic[strval($i)] = round($won / count($latestRaceIds), 2);
            }

            $statistic['topTwo'] = floatval($statistic['1']) + floatval($statistic['2']);
            $statistic['topThree'] = $statistic['topTwo'] + floatval($statistic['3']);

            $statistics[] = $statistic;
        }

        return $statistics;
    }

    /**
     * @param integer[] $latestRaceIds
     *
     * @return mixed[]
     */
    private function getPlacesOrder(array $latestRaceIds)
    {
        $races = Race::query()
            ->whereIn('races.id', $latestRaceIds)
            ->with(['members' => function ($query): void {
                $query->orderBy('member_race.place');
            }])
            ->get();

        $distribution = [];
        foreach ($races as $race) {
            /** @var Member $member */
            foreach ($race->members as $member) {
                $place = $member->pivot->place;

                if (!isset($distribution[$place])) {
                    $distribution[$place] = [
                        'place' => $place,
                        'members' => [],
                    ];
                }

                $distribution[$place]['members'][] = [
                    'number' => $member->number,
                    'color' => $member->color,
                ];
            }
        }

        return array_values($distribution);
    }
}
