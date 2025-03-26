<?php

declare(strict_types=1);

namespace App\Enums;

enum ApiErrorCode: string
{
    case VALIDATION_ERROR = 'validation_error';
    case UNAUTHENTICATED = 'unauthenticated';
    case FORBIDDEN = 'forbidden';
    case NOT_FOUND = 'not_found';
    case INTERNAL_ERROR = 'internal_error';
    case MODEL_NOT_FOUND = 'model_not_found';
    case BAD_REQUEST = 'bad_request';
    case ERROR_OWNERSHIP = 'error_ownership';

    public function message(): string
    {
        return match ($this) {
            self::VALIDATION_ERROR => 'The given data was invalid',
            self::UNAUTHENTICATED => 'Unauthenticated',
            self::FORBIDDEN => 'Forbidden',
            self::NOT_FOUND => 'Not Found',
            self::INTERNAL_ERROR => 'Internal Server Error',
            self::MODEL_NOT_FOUND => 'Record not found',
            self::BAD_REQUEST => 'Bad Request',
            self::ERROR_OWNERSHIP => 'error update ownership',
        };
    }

    public function httpStatusCode(): int
    {
        return match ($this) {
            self::VALIDATION_ERROR => 422,
            self::UNAUTHENTICATED => 401,
            self::FORBIDDEN, self::ERROR_OWNERSHIP => 403,
            self::NOT_FOUND, self::MODEL_NOT_FOUND => 404,
            self::INTERNAL_ERROR => 500,
            self::BAD_REQUEST => 400
        };
    }
}
