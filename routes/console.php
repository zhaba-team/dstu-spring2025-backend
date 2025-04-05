<?php

declare(strict_types=1);

use App\Console\Commands\UpdateStatisticAndStartRace;
use App\Console\Commands\GetCurrentLocationRunners;
use Illuminate\Support\Facades\Schedule;

Schedule::command(UpdateStatisticAndStartRace::class)->everyMinute();
Schedule::command(GetCurrentLocationRunners::class)->everySecond();
