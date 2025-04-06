<?php

declare(strict_types=1);

namespace App\Services\Race;

use App\DTO\Race\RaceMembersDTO;

readonly class RunnerService
{
    private const NUMBER_FOR_PERCENT = 100;
    private const COUNT_NUMBER_FOR_ROUND = 2;

    public function __construct(
        private RaceMembersDTO $runner
    ) {
    }

    public function calculateTimeRaceFined(int $currentSecondBeforeStartRace): float
    {
        $numberPercent = self::NUMBER_FOR_PERCENT;
        $countRound = self::COUNT_NUMBER_FOR_ROUND;

        $result = $currentSecondBeforeStartRace * $numberPercent / $this->runner->raceTime;

        if ($result >= $numberPercent) {
            return $numberPercent;
        }

        return round($result, $countRound);
    }
}
