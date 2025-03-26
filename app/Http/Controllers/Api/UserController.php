<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\Controllers\UserService;

final readonly class UserController
{
    public function __construct(
        private UserService $userService
    ) {
    }

    /** @return array<string, mixed> */
    public function roles(): array
    {
        return $this->userService->roles();
    }
}
