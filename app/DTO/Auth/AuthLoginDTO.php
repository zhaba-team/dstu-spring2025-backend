<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Dto;

class AuthLoginDTO extends DTO
{
    public function __construct(
        #[Email]
        public string $email,
        #[Password(min:8)]
        public string $password
    ) {
    }
}
