<?php

namespace App\Repositories;

use App\Models\Schedule;
use Throwable;

class ScheduleRepository
{
    public function store(array $data): Schedule
    {
        try {
            return Schedule::query()->create($data);
        } catch (Throwable $ex) {
            dd($ex->getMessage());
        }
    }

    public function getByEmployeeId(int $employeeId): ?Schedule
    {
        return Schedule::query()
            ->where('employee_id', $employeeId)
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function delete(int $id): void
    {
        Schedule::query()
            ->where('id', $id)
            ->delete();
    }

    public function getById(int $id): ?Schedule
    {
        return Schedule::query()
            ->where('id', $id)
            ->first();
    }
}
