<?php

namespace App\Dtos;

use Illuminate\Database\Eloquent\Collection;

class SettingsIntervalsDto
{
    public function __construct(
        public string $startTime,
        public string $endTime,
        public string $settingsId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'settings_id' => $this->settingsId,
        ];
    }

    public function toResponse(int $id): array
    {
        return [
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'settings_id' => $this->settingsId,
            'id' => $id,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            startTime: $data['start_time'],
            endTime: $data['end_time'],
            settingsId: $data['settings_id'],
        );
    }
}
