<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Enums\ApiErrorCode;
use Closure;

class CheckUserOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->route('userId');

        if (!is_numeric($userId)) {
            $error = ApiErrorCode::BAD_REQUEST;

            abort($error->httpStatusCode(), $error->message());
        }

        $userId = (int) $userId;

        if (auth()->id() !== $userId) {
            $error = ApiErrorCode::ERROR_OWNERSHIP;

            abort($error->httpStatusCode(), $error->message());
        }

        return $next($request);
    }
}
