<?php

namespace App\Enums;

enum UserRole: string
{
    case Developer = 'developer';
    case Admin = 'admin';
    case User = 'user';

    public function displayName(): string
    {
        return match($this) {
            self::Developer => 'Разработчик',
            self::Admin => 'Администратор',
            self::User => 'Пользователь',
        };
    }
}
