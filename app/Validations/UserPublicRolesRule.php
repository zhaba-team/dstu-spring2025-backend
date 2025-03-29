<?php

declare(strict_types=1);

namespace App\Validations;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\UserRole;
use Closure;

class UserPublicRolesRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $publicRoles = UserRole::publicRoles();

        foreach ($publicRoles as $role) {
            if ($value !== $role->value) {
                $fail(__('auth.err_role'));
            }
        }
    }
}
