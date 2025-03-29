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
use Knuckles\Scribe\Attributes\Response;

#[Group('Авторизация')]
final readonly class AuthController
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    /** @return array<string, mixed> */
    #[Response(content: '{"message": "User not found"}', status: 404, description: "user not found z")]
    #[BodyParam('name', 'string', 'username', required: true)]
    public function register(AuthRegisterDTO $authRegisterDTO): array
    {
        return $this->authService->register($authRegisterDTO);
    }

    /**
     * @return array<string, mixed>
     * @throws ValidationException
     */
    public function login(AuthLoginDTO $authLoginDTO): array
    {
        return $this->authService->login($authLoginDTO);
    }


    /** @return array<string, string> */
    #[Authenticated]
    public function logout(): array
    {
        return $this->authService->logout();
    }
}
