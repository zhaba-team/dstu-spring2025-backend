<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\Controllers\StatisticService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StatisticController
{
    public function __construct(
        private readonly StatisticService $statisticService,
    ) {
    }

    public function getAll(Request $request): JsonResponse
    {
        $actual = $request->query('actual');

        $statistics = $this->statisticService->collect($actual ? (int) $actual : null);

        return new JsonResponse($statistics);
    }
}
