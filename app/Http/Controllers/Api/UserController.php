<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\Controllers\UserService;
use App\DTO\User\UserUpdateDTO;
use App\Models\User;

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

    /** @return array<string, mixed> */
    public function show(int $id): array
    {
        $user = User::query()->findOrFail($id);

        return $this->userService->show($user);
    }

    /** @return array<string, mixed>  */
    public function update(int $userId, UserUpdateDTO $requestDTO): array
    {
        $user = User::query()->findOrFail($userId);

        return $this->userService->update($user, $requestDTO);
    }
}
