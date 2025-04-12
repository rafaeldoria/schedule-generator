<?php

namespace App\Dtos;

class ScheduleDto
{
    private const STATUS_DEFAULT = 0;

    public function __construct(
        public string $generatedSchedule,
        public int $employeeId,
        public string $status = self::STATUS_DEFAULT,
    ) {
    }

    public function toArray(): array
    {
        return [
            'generated_schedule' => $this->generatedSchedule,
            'employee_id' => $this->employeeId,
            'status' => $this->status,
        ];
    }
}
