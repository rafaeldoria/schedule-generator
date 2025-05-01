<?php

namespace App\Services;

use App\Dtos\ScheduleDto;
use App\Helpers\ScheduleHelper;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;

class ScheduleService
{
    public function __construct(protected ScheduleRepository $repository)
    {
    }

    public function getByid(int $employeeId): array
    {
        $schedule = $this->repository->getById($employeeId);

        if (is_null($schedule)) {
            return [];
        }

        return $this->returnSchedule($schedule);
    }

    public function store(array $times, int $employeeId): Schedule
    {
        $scheduleDto = new ScheduleDto(json_encode($times), $employeeId);

        return $this->repository->store($scheduleDto->toArray());
    }

    public function getByEmployee(int $employeeId): array
    {
        $schedule = $this->repository->getByEmployeeId($employeeId);

        if (is_null($schedule)) {
            return [];
        }

        return $this->returnSchedule($schedule);
    }

    private function returnSchedule(Schedule $schedule): array
    {
        if (ScheduleHelper::validateLastDateSchedule($schedule->generated_schedule)) {
            $this->repository->delete($schedule->id);

            return [];
        }

        $scheduleDto = new ScheduleDto(
            $schedule->generated_schedule,
            $schedule->employee_id,
            $schedule->status
        );

        return $scheduleDto->toResponse($schedule->id);
    }
}
