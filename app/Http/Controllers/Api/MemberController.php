<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Member;
use Illuminate\Http\JsonResponse;

class MemberController
{
    public function getAll(): JsonResponse
    {
        $members = Member::all();

        return new JsonResponse($members);
    }
}
