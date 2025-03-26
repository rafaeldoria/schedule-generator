<?php

namespace App\Dtos;

use Illuminate\Database\Eloquent\Collection;

class SettingsIntervalsDto
{
    public function __construct(
        public string $startTime,
        public string $endTime,
        public string $employeeSettingsId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'employee_settings_id' => $this->employeeSettingsId,
        ];
    }

    public function toResponse(int $id): array
    {
        return [
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'employee_settings_id' => $this->employeeSettingsId,
            'id' => $id,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            startTime: $data['start_time'],
            endTime: $data['end_time'],
            employeeSettingsId: $data['employee_settings_id'],
        );
    }
}
