<?php

declare(strict_types=1);

namespace App\Validations\Attributes;

use Attribute;
use App\Validations\UserPublicRolesRule;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
final class UserPublicRole extends CustomValidationAttribute
{
    public function getRules(ValidationPath $path): UserPublicRolesRule
    {
        return new UserPublicRolesRule();
    }
}
