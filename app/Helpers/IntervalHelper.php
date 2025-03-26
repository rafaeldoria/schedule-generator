<?php

namespace App\Helpers;

use App\Dtos\SettingsIntervalsDto;
use App\Models\EmployeeSettings;

class IntervalHelper
{
    public static function getIntervals(EmployeeSettings $settings): array
    {
        $intervals = [];

        $intervalsSettings = $settings->intervals;

        if (!empty($intervalsSettings)) {
            foreach ($intervalsSettings as $intervalSetting) {
                $intervalsDto = SettingsIntervalsDto::fromArray($intervalSetting->toArray());
                $intervals[] = $intervalsDto->toResponse($intervalSetting['id']) ?? [];
            }
        }

        return $intervals;
    }
}
