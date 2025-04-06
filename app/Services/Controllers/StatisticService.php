<?php

declare(strict_types=1);

namespace App\Services\Controllers;

use App\Models\Member;
use App\Models\Race;

class StatisticService
{
    /** @return mixed[] */
    public function collect(?int $actual = null): array
    {
        /** @var integer $numberOfRaces */
        $numberOfRaces = config('settings.number_of_races');

        $lastRaceId = Race::query()->latest()->first()->id ?? $numberOfRaces;
        if ($actual < $numberOfRaces) {
            $offset = $lastRaceId - $numberOfRaces;
            $actual = $numberOfRaces;
        } elseif ($actual > $lastRaceId) {
            $offset = 0;
            $actual = $lastRaceId;
        } else {
            $offset = $lastRaceId - $actual;
        }

        /** @var integer[] $latestRaceIds */
        $latestRaceIds = Race::query()
            ->latest('id')
            ->limit($numberOfRaces)
            ->offset($offset)
            ->pluck('id')
            ->toArray();

        return [
            'actual'               => $actual,
            'places_order'         => $this->getPlacesOrder($latestRaceIds),
            'single_probabilities' => $this->getSingleProbabilities($latestRaceIds),
            'pair_probabilities'   => $this->getPairProbabilities($latestRaceIds),
        ];
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
                'color'  => $member->color,
            ];

            for ($i = 1; $i < $placesCount + 1; ++$i) {
                $won = $member
                    ->races()
                    ->whereIn('race_id', $latestRaceIds)
                    ->where('place', $i)
                    ->count();

                $statistic[strval($i)] = round($won / count($latestRaceIds), 2);
            }

            $statistic['topTwo'] = round(floatval($statistic['1']) + floatval($statistic['2']), 2);
            $statistic['topThree'] = round($statistic['topTwo'] + floatval($statistic['3']), 2);

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
            ->with([
                       'members' => function ($query): void {
                           $query->orderBy('member_race.place');
                       },
                   ])
            ->get();

        $distribution = [];
        foreach ($races as $race) {
            /** @var Member $member */
            foreach ($race->members as $member) {
                $place = $member->pivot->place;

                if (! isset($distribution[$place])) {
                    $distribution[$place] = [
                        'place'   => $place,
                        'members' => [],
                    ];
                }

                $distribution[$place]['members'][] = [
                    'number' => $member->number,
                    'color'  => $member->color,
                ];
            }
        }

        return array_values($distribution);
    }

    /**
     * @param integer[] $latestRaceIds
     *
     * @return mixed[]
     */
    public function getPairProbabilities(array $latestRaceIds)
    {
        /** @var integer $placesCount */
        $placesCount = config('settings.number_of_members');

        $members = Member::all();

        $racesWithWinners = Race::query()
            ->whereIn('id', $latestRaceIds)
            ->with([
                       'members' => function ($query): void {
                           $query->wherePivotIn('place', [1, 2])
                               ->orderBy('place');
                       },
                   ])
            ->get();

        $pairs = [];
        foreach ($racesWithWinners as $race) {
            $pair = [];
            /** @var Member $member */
            foreach ($race->members as $member) {
                $pair[] = $member->id;
            }

            $pairs[$pair[0]][] = $pair[1];
            $pairs[$pair[1]][] = $pair[0];
        }

        $propabilities = [];
        /** @var Member $member */
        foreach ($members as $member) {
            $propabilities[$member->id] = [
                'number' => $member->number,
                'color'  => $member->color,
            ];

            for ($i = 1; $i <= $placesCount; ++$i) {
                $propabilities[$member->id][$i] = $i === $member->id ? null : 0;
            }

            ksort($pairs);
            foreach ($pairs as $key => $values) {
                $counts = array_count_values($values);

                $formattedCounts = [];
                foreach ($counts as $number => $count) {
                    $formattedCounts[(string) $number] = $count;
                }

                if ($member->id === $key) {
                    foreach ($formattedCounts as $number => $count) {
                        $propabilities[$member->id][$number] = round($count / $placesCount, 2);
                    }
                }
            }
        }

        return array_values($propabilities);
    }
}
