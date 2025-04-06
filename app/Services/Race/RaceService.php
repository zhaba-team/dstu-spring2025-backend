<?php

declare(strict_types=1);

namespace App\Services\Race;

use App\DTO\Race\RaceInformationDTO;
use App\DTO\Race\RaceMembersDTO;
use App\Models\Member;
use App\Models\Race;
use Random\RandomException;

readonly class RaceService
{
    public function __construct(
        private string $time,
    ) {
    }

    /**
     * @throws RandomException
     */
    public function getInformation(): RaceInformationDTO
    {
        $raceMembers = [];
        $racePlacesInfo = [];

        $members = Member::all();

        $race = Race::query()->create();

        foreach ($members as $member) {
            $raceTime = random_int(10, 15);

            $racePlacesInfo[] = [
                'id'   => $member->id,
                'time' => $raceTime,
            ];

            $raceMembers[] = new RaceMembersDTO($member->color, $raceTime);
        }

        usort($racePlacesInfo, static function (array $a, array $b): int {
            return $a['time'] <=> $b['time'];
        });

        foreach ($racePlacesInfo as $key => $racePlace) {
            $place = $key + 1;

            $race->members()->attach($racePlace['id'], [
                'place' => $place,
            ]);
        }

        return new RaceInformationDTO($this->time, $raceMembers);
    }
}
