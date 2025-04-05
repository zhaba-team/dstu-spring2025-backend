<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('onlineRace', static function (): true {
    return true;
});
