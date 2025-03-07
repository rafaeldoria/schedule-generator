<?php

namespace App\Services;

use App\Dtos\SettingsDto;
use App\Models\Settings;
use App\Repositories\SettingsRepository;

class SettingsService
{
    public function __construct(protected SettingsRepository $repository)
    {
    }

    public function getById(int $id): array
    {
        $settings = $this->repository->findById($id);

        if (empty($settings)) {
            return [];
        }

        $settingsDto = SettingsDto::fromArray($settings->toArray());

        return $settingsDto->toResponse($settings['id']);
    }

    public function getByEmployeeId(int $employeeId): array
    {
        $settings = $this->repository->findByEmployeeId($employeeId);

        if (empty($settings)) {
            return [];
        }

        $settingsDto = SettingsDto::fromArray($settings->toArray());

        return $settingsDto->toArray();
    }

    public function createSettings(array $data): Settings
    {
        $settingsDto = SettingsDto::fromArray($data);

        return $this->repository->create($settingsDto->toArray());
    }

    public function updateSettings(array $data, int $id): bool
    {
        $settingsDto = SettingsDto::fromArray($data);

        return $this->repository->update($settingsDto->toArray(), $id);
    }
}
