<?php

declare(strict_types=1);

namespace App\DTO\Race;

use Spatie\LaravelData\Data;

class RaceInformationDTO extends Data
{
    /** @param array<int, RaceMembersDTO> $members */
    public function __construct(
        public string $time,
        public array $members
    ) {
    }
}
