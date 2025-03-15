<?php

namespace App\DTO\User;

use App\Models\User;
use Spatie\LaravelData\Data;

class UserAuthShowDTO extends Data
{
    public function __construct(
        public User $user,
        public string $token,
    ){
    }

    public static function fromModel(User $user): self
    {
        return new self(
            $user,
            $user->createToken('auth_token')->plainTextToken
        );
    }
}
