<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\Email\EmailVerificationCodeDTO;
use App\Services\Controllers\EmailVerificationService;
use Random\RandomException;

final readonly class EmailVerificationController
{
    public function __construct(
        private EmailVerificationService $emailVerificationService
    ) {
    }

    /**
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function send(): array
    {
        return $this->emailVerificationService->send();
    }

    /** @return array<string, mixed> */
    public function verify(EmailVerificationCodeDTO $requestDTO): array
    {
        return $this->emailVerificationService->verify($requestDTO);
    }
}
