<?php

declare(strict_types=1);

namespace App\DTO\Race;

use Spatie\LaravelData\Data;

class RaceMembersDTO extends Data
{
    public function __construct(
        public string $color,
        public float $raceTime,
    ) {
    }
}
