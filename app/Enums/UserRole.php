<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case Developer = 'developer';
    case Admin = 'admin';
    case User = 'user';

    public function displayName(): string
    {
        return match ($this) {
            self::Developer => 'Разработчик',
            self::Admin => 'Администратор',
            self::User => 'Пользователь',
        };
    }

    public function canFullAccess(): bool
    {
        return $this === self::Developer || $this === self::Admin;
    }

    /** @return array<int, UserRole> */
    public static function publicRoles(): array
    {
        $publicRoles = [];

        foreach (self::cases() as $role) {
            if ($role !== self::Developer && $role !== self::Admin) {
                $publicRoles[] = $role;
            }
        }

        return $publicRoles;
    }
}
