<?php

namespace App\Dtos;

use App\Enums\StatusScheduleDetailsEnum;

class ScheduleDetailsDto
{
    public function __construct(
        public string $date,
        public string $time,
        public int $scheduleId,
        public int $customerId,
        public int $status = StatusScheduleDetailsEnum::SCHEDULED->value,
    ) {
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date,
            'time' => $this->time,
            'schedule_id' => $this->scheduleId,
            'customer_id' => $this->customerId,
            'status' => $this->status,
        ];
    }

    public function toResponse(int $id): array
    {
        return [
            'date' => $this->date,
            'time' => $this->time,
            'schedule_id' => $this->scheduleId,
            'customer_id' => $this->customerId,
            'status' => $this->status,
            'id' => $id,
        ];
    }
}
