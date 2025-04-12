<?php

namespace App\Helpers;

use App\Dtos\SettingsBreakingsDto;
use App\Models\EmployeeSettings;

class BreakingHelper
{
    public static function getBreakings(EmployeeSettings $settings): array
    {
        $breakings = [];

        $breakingsSettings = $settings->breakings;

        if (!empty($breakingsSettings)) {
            foreach ($breakingsSettings as $breakingSetting) {
                $breakingsDto = SettingsBreakingsDto::fromArray($breakingSetting->toArray());
                $breakings[] = $breakingsDto->toResponse($breakingSetting['id']) ?? [];
            }
        }

        return $breakings;
    }
}
