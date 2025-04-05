<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('onlineRace', static function () {
    return true;
});
