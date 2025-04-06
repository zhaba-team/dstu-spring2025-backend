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
            $raceTime = $this->getRiceTime($member);

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

    /**
     * @throws RandomException
     */
    private function getRiceTime(Member $member)
    {
        $distance = 100;

        /**
         * Время реакции на старте
         */
        $timeReactBase = $member->reaction_time;

        /**
         * Ускорение
         */
        $accelerationBase = $member->boost;

        /**
         * Максимальная скорость
         */
        $maxSpeedBase = $member->max_speed;

        /**
         * Коэф. потери скорости
         */
        $speedLossBase =  $member->speed_loss;

        $randomizer = new \Random\Randomizer();


        /**
         * Стабильность чювака
         */
        $stability = $randomizer->getFloat($member->stability_from, $member->stability_to);

        // Фаза старта
        $timeReact = $timeReactBase + random_int(0, 5) / 100 * (6 - $stability);

        // Фаза разгона
        $accelerationActual = $accelerationBase * (1 + random_int(-10, 10) / 100 * (1 / $stability));

        $maxSpeedActual = $maxSpeedBase * (1 + random_int(-5, 5) / 100 * (1 / $stability));

        $timeAcceleration = $maxSpeedActual / $accelerationActual;

        // Фаза поддержания скорости

        $distanceAcceleration = 0.5 * $accelerationActual * $timeAcceleration ** 2;

        $distanceRemaining = $distance - $distanceAcceleration;

        if ($distanceRemaining <= 0) {
            return $timeReact + $timeAcceleration;
        }

        $timeCruise = $distanceRemaining / $maxSpeedActual;

        // Фаза потери скорости

        $speedLossActual = $speedLossBase * (1 + random_int(-20, 20) / 100 * (1 / $stability));

        $speedFinal = $maxSpeedActual - $speedLossActual * $timeCruise;

        $timeFinal = 0;

        if ($speedFinal < 0.9 * $maxSpeedActual) {
            $distanceRemaining = $distance - ($distanceAcceleration + $maxSpeedActual * $timeCruise);

            $timeFinal = ($maxSpeedActual - sqrt($maxSpeedActual ** 2 - 2 * $speedLossActual * $distanceRemaining)) / $speedLossActual;
        }

        return $timeReact + $timeAcceleration + $timeCruise + $timeFinal;
    }
}
