<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateStatisticAndStartRace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'race:update-and-start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет статистику и запускает новый забег';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // сначала надо отдать статистику отчетов а потом запустить забег
    }
}
