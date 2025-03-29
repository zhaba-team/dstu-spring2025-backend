<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

class CheckUserOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->route('userId');

        if (!is_numeric($userId)) {
            abort(Response::HTTP_BAD_REQUEST, __('user.err_id'));
        }

        $userId = (int) $userId;

        if (auth()->id() !== $userId) {
            abort(Response::HTTP_BAD_REQUEST, __('user.ownership'));
        }

        return $next($request);
    }
}
