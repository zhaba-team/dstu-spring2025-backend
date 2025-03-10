<?php

namespace App\Builders;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function isDeveloper()
    {
        $this->where('role', UserRole::Developer);
    }
}
