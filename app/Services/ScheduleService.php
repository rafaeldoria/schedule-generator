<?php

namespace App\Services;

use App\Dtos\ScheduleDto;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;
use Carbon\Carbon;

class ScheduleService
{
    public function __construct(protected ScheduleRepository $repository)
    {
    }

    public function store(array $times, int $id): Schedule
    {
        $scheduleDto = new ScheduleDto(json_encode($times),$id);

        return $this->repository->store($scheduleDto->toArray());
    }

    public function getByEmployee(int $employeeId): array
    {
        $schedule = $this->repository->getByEmployeeId($employeeId);

        if (is_null($schedule)) {
            return [];
        }

        if ($this->validateLastDateSchedule($schedule->generated_schedule)) {
            $this->repository->delete($schedule->id);

            return [];
        }

        return $schedule->toArray();
    }

    private function validateLastDateSchedule(string $generated_schedule): bool
    {
        $lastDateSchedule = Carbon::parse(array_key_last(json_decode($generated_schedule, true)));

        return $lastDateSchedule->lt(Carbon::today());
    }
}
