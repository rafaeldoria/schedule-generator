<?php

namespace App\Services;

use App\Dtos\EmployeeSettingsDto;
use App\Helpers\BreakingHelper;
use App\Models\SettingsBreaking;
use App\Models\EmployeeSettings;
use App\Repositories\EmployeeSettingsRepository;

class EmployeeSettingsService
{
    private array $breakings = [];

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

        $this->setBreakings($settings);

        return [
            'settings' => $settingsDto->toResponse($settings['id']),
            'breakings' => $this->breakings,
        ];
    }

    public function getByEmployeeId(int $employeeId): array
    {
        $settings = $this->repository->findByEmployeeId($employeeId);

        if (empty($settings)) {
            return [];
        }

        $settingsDto = EmployeeSettingsDto::fromArray($settings->toArray());

        $this->setBreakings($settings);

        return [
            'settings' => $settingsDto->toArray(),
            'breakings' => $this->breakings,
        ];
    }

    public function createSettings(array $data): array
    {
        $settingsDto = EmployeeSettingsDto::fromArray($data);
        $settings = $this->repository->create($settingsDto->toArray());

        if (!empty($data['breakings'])) {
            foreach ($data['breakings'] as $breaking) {
                $breaking['employee_settings_id'] = $settings->id;

                $this->breakings[] = SettingsBreaking::query()->updateOrCreate([
                    'id' => $breaking['id'] ?? null,
                ], $breaking);
            }
        }

        return [
            'settings' => $settings,
            'breakings' => $this->breakings,
        ];
    }

    public function setBreakings(EmployeeSettings $settings): void
    {
        $this->breakings = BreakingHelper::getBreakings($settings);
    }
}
