<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $number
 * @property string $color
 * @property MemberRace $pivot
 */
class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = [
        'reaction_time',
        'boost',
        'max_speed',
        'speed_loss',
        'number',
        'stability_from',
        'stability_to',
        'color',
    ];

    /**
     * @phpstan-ignore-next-line
     */
    public function races(): BelongsToMany
    {
        return $this->belongsToMany(Race::class)->withPivot('place');
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function memberRaces(): HasMany
    {
        return $this->hasMany(MemberRace::class);
    }
}
