<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetCurrentLocationRunners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:current-location-runners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Показывает текущие положение бегунов';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Вне зависимости, где бегуны отдавать их точки
    }
}
