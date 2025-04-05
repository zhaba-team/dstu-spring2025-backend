<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Race extends Model
{
    /** @use HasFactory<\Database\Factories\RaceFactory> */
    use HasFactory;

    /**
     * @phpstan-ignore-next-line
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class)->withPivot('place');
    }
}
