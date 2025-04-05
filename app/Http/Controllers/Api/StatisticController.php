<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\Controllers\StatisticService;
use Illuminate\Http\JsonResponse;

class StatisticController
{
    public function __construct(
        private readonly StatisticService $statisticService,
    ) {
    }

    public function getAll(): JsonResponse
    {
        $statistics = $this->statisticService->collect();

        return new JsonResponse($statistics);
    }
}
