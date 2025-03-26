<?php

declare(strict_types=1);

namespace App\Services\Controllers;

use App\DTO\User\UserShowDTO;
use App\Enums\UserRole;
use App\Models\User;

final class UserService
{
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
}
