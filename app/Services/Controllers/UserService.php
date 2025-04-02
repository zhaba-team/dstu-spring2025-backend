<?php

declare(strict_types=1);

namespace App\Services\Controllers;

use App\DTO\User\UserUpdateDTO;
use App\DTO\User\UserShowDTO;
use App\Enums\UserRole;
use App\Models\User;
use App\Services\Files\RequestFileStorage;

final class UserService
{
    public function __construct(
        public RequestFileStorage $requestFileStorage,
    ) {
    }

    /** @return array<string, mixed> */
    public function show(User $user): array
    {
        return UserShowDTO::from($user)->toArray();
    }

    /** @return array<string, mixed> */
    public function roles(): array
    {
        $roles = UserRole::publicRoles();

        return [
            'roles' => array_map(static function ($theme): array {
                return [
                    'id'   => $theme->value,
                    'name' => $theme->displayName(),
                ];
            }, $roles),
        ];
    }

    /** @return array<string, mixed> */
    public function update(User $user, UserUpdateDTO $requestDTO): array
    {
        $savedAvatar = null;

        if (isset($requestDTO->avatar)) {
            $savedAvatar = $this->requestFileStorage->saveFile($requestDTO->avatar);
        }

        $user->name = $requestDTO->name;
        $user->email = $requestDTO->email;

        if (isset($savedAvatar)) {
            $user->avatar_id = $savedAvatar->id;
        }

        $user->save();

        return UserShowDTO::from($user)->toArray();
    }
}
