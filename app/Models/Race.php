<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\RaceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 */
#[ObservedBy([RaceObserver::class])]
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

    /**
     * @phpstan-ignore-next-line
     */
    public function raceMembers(): HasMany
    {
        return $this->hasMany(MemberRace::class);
    }
}
