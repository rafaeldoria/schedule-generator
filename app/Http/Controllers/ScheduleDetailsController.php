<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleDetailsRequest;
use App\Repositories\ScheduleDetailsRepository;
use App\Services\ScheduleDetailsService;
use Illuminate\Http\JsonResponse;

class ScheduleDetailsController
{
    public function store(StoreScheduleDetailsRequest $request): JsonResponse
    {
        $service = new ScheduleDetailsService(new ScheduleDetailsRepository(), $request->all());
        return response()->json([$service->store()]);
    }
}
