<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use Knuckles\Scribe\Attributes\Authenticated;
use App\Services\Controllers\AuthService;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use App\DTO\Auth\AuthRegisterDTO;
use App\DTO\Auth\AuthLoginDTO;

#[Group('Авторизация 1')]
final readonly class AuthController
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    /**
     * Регистрация пользователя
     *
     * @return array<string, mixed>
     */
    #[BodyParam('name', 'string', 'Имя пользователя', required: true, example: 'name')]
    #[BodyParam('email', 'string', 'Почта', required: true, example: 'test@example.com')]
    #[BodyParam('role', 'string', 'Получить роль для регистрации "/api/users/roles/"', required: true, example: 'user')]
    #[BodyParam('password', 'string', 'Пароль', required: true, example: 'password')]
    public function register(AuthRegisterDTO $authRegisterDTO): array
    {
        return $this->authService->register($authRegisterDTO);
    }

    /**
     * Авторизация пользователя
     *
     * @return array<string, mixed>
     * @throws ValidationException
     */
    #[BodyParam('email', 'string', 'Почта', required: true, example: 'test@example.com')]
    #[BodyParam('password', 'string', 'Пароль', required: true, example: 'password')]
    public function login(AuthLoginDTO $authLoginDTO): array
    {
        return $this->authService->login($authLoginDTO);
    }


    /**
     * Выход из аккаунта
     *
     * @return array<string, string>
     */
    #[Authenticated]
    public function logout(): array
    {
        return $this->authService->logout();
    }
}
