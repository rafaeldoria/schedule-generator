<?php

namespace App\Dtos;

class EmployeeSettingsDto
{
    public function __construct(
        public string $duration,
        public string $startTime,
        public string $endTime,
        public ?bool $saturdayOff,
        public ?string $closeDays,
        public string $employeeId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'duration' => $this->duration,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'saturday_off' => $this->saturdayOff,
            'close_days' => $this->closeDays,
            'employee_id' => $this->employeeId,
        ];
    }

    public function toResponse(int $id): array
    {
        return [
            'duration' => $this->duration,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'saturday_off' => $this->saturdayOff,
            'close_days' => $this->closeDays,
            'employee_id' => $this->employeeId,
            'id' => $id,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            duration: $data['duration'],
            startTime: $data['start_time'],
            endTime: $data['end_time'],
            saturdayOff: $data['saturday_off'] ?? null,
            closeDays: $data['close_days'] ?? null,
            employeeId: $data['employee_id'],
        );
    }
}
