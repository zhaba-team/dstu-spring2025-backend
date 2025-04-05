<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MemberRace extends Pivot
{
    public $incrementing = true;
    public $timestamps = false;

    /**
     * @phpstan-ignore-next-line
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }
}
