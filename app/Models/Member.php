<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'color',
    ];

    /**
     * @phpstan-ignore-next-line
     */
    public function races(): BelongsToMany
    {
        return $this->belongsToMany(Race::class)->withPivot('place');
    }
}
