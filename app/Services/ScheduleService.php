<?php

namespace App\Services;

use App\Dtos\ScheduleDto;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;

class ScheduleService
{
    public function store(array $times, int $id): Schedule
    {
        $scheduleDto = new ScheduleDto(json_encode($times),$id);
        $repository = app(ScheduleRepository::class);

        return $repository->store($scheduleDto->toArray());
    }
}
