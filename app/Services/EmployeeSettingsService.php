<?php

namespace App\Services;

use App\Dtos\SettingsIntervalsDto;
use App\Dtos\EmployeeSettingsDto;
use App\Models\SettingsInterval;
use App\Models\EmployeeSettings;
use App\Repositories\EmployeeSettingsRepository;

class EmployeeSettingsService
{
    private array $intervals = [];

    public function __construct(protected EmployeeSettingsRepository $repository)
    {
    }

    public function getById(int $id): array
    {
        $settings = $this->repository->findById($id);

        if (empty($settings)) {
            return [];
        }

        $settingsDto = EmployeeSettingsDto::fromArray($settings->toArray());

        $this->setIntervals($settings);

        return [
            'settings' => $settingsDto->toResponse($settings['id']),
            'intervals' => $this->intervals,
        ];
    }

    public function getByEmployeeId(int $employeeId): array
    {
        $settings = $this->repository->findByEmployeeId($employeeId);

        if (empty($settings)) {
            return [];
        }

        $settingsDto = EmployeeSettingsDto::fromArray($settings->toArray());

        $this->setIntervals($settings);

        return [
            'settings' => $settingsDto->toArray(),
            'intervals' => $this->intervals,
        ];
    }

    public function createSettings(array $data): array
    {
        $settingsDto = EmployeeSettingsDto::fromArray($data);
        $settings = $this->repository->create($settingsDto->toArray());

        if (!empty($data['intervals'])) {
            foreach ($data['intervals'] as $interval) {
                $this->intervals[] = SettingsInterval::query()->updateOrCreate([
                    'settings_id' => $settings->id,
                ], $interval);
            }
        }

        return [
            'settings' => $settings,
            'intervals' => $this->intervals,
        ];
    }

    public function setIntervals(EmployeeSettings $settings): void
    {
        $intervalsSettings = $settings->intervalsT;

        if (!empty($intervalsSettings)) {
            foreach ($intervalsSettings as $intervalSetting) {
                $intervalsDto = SettingsIntervalsDto::fromArray($intervalSetting->toArray());
                $this->intervals[] = $intervalsDto->toResponse($intervalSetting['id']) ?? [];
            }
        }
    }
}
