<?php

namespace App\Repositories;

use App\Models\ScheduleDetails;

class ScheduleDetailsRepository
{
    public function store(array $data): ScheduleDetails
    {
        return ScheduleDetails::query()->create($data);
    }

    public function update(array $data, int $scheduleDetailsId): ScheduleDetails
    {
        $schedule = ScheduleDetails::query()->findOrFail($scheduleDetailsId);

        $schedule->update($data);

        return $schedule;
    }
}
