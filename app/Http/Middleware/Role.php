<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param string ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! Auth::check()) {
            abort(Response::HTTP_UNAUTHORIZED, __('auth.unauthorised'));
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user?->hasRole($role)) {
                return $next($request);
            }
        }

        abort(Response::HTTP_BAD_REQUEST, __('auth.err_role'));
    }
}
