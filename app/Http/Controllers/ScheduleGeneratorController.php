<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleGeneratorRequest;
use App\Services\ScheduleGeneratorService;
use Illuminate\Http\JsonResponse;

class ScheduleGeneratorController
{
    public function generate(StoreScheduleGeneratorRequest $request): JsonResponse
    {
        $service = new ScheduleGeneratorService($request->all());
        $service->handle();

        return response()->json([
            'data' => $service->times
        ]);
    }
}
