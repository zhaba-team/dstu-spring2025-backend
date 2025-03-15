<?php

namespace App\DTO\Auth;

use App\Enums\UserRole;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Dto;

class AuthRegisterDTO extends Dto
{
    public function __construct(
        #[Max(225)]
        public string $name,
        #[Email]
        #[Unique('users', 'email')]
        public string $email,
        public UserRole $role,
        #[Password(min:8)]
        public string $password,
    ) {
    }
}
