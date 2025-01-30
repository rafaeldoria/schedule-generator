<?php

namespace App\Http\Controllers;

use AllowDynamicProperties;
use App\Http\Requests\StoreScheduleRequest;
use App\Services\ScheduleGeneratorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ScheduleGeneratorController
{
    public function generate(StoreScheduleRequest $request): JsonResponse
    {
        $service = new ScheduleGeneratorService($request);
        $service->handle();

        return response()->json([
            'data' => $service->times
        ]);
    }
}
