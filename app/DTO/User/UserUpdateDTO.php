<?php

declare(strict_types=1);

namespace App\DTO\User;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class UserUpdateDTO extends Data
{
    public function __construct(
        #[Unique(
            table: 'users',
            ignore: new RouteParameterReference('userId')
        ), Max(50)]
        public string $name,
        #[Unique(
            table: 'users',
            ignore: new RouteParameterReference('userId')
        ), Email]
        public string $email,
        public ?UploadedFile $avatar,
    ) {
    }
}
