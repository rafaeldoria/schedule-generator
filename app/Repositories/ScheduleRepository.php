<?php

namespace App\Repositories;

use App\Models\Schedule;

class ScheduleRepository
{
    public function store(array $data): Schedule
    {
        return Schedule::query()->create($data);
    }
}
