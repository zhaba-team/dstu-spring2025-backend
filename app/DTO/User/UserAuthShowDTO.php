<?php

declare(strict_types=1);

namespace App\DTO\User;

use App\Models\User;
use Spatie\LaravelData\Data;

class UserAuthShowDTO extends Data
{
    public function __construct(
        public UserShowDTO $user,
        public string $token,
    ) {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            UserShowDTO::from($user),
            $user->createToken('auth_token')->plainTextToken
        );
    }
}
