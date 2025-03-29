<?php

declare(strict_types=1);

namespace App\DTO\Email;

use Spatie\LaravelData\Dto;

class EmailVerificationCodeDTO extends DTO
{
    public function __construct(
        public int $code,
    ) {
    }
}
