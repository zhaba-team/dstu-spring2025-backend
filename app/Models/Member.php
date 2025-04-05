<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function races(): HasMany
    {
        return $this->hasMany(Race::class);
    }
}
