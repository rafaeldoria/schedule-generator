<?php

namespace App\Http\Controllers;

use App\Models\SettingsInterval;
use Illuminate\Http\JsonResponse;

class SettingsIntervalController
{
    public function delete(SettingsInterval $interval): JsonResponse
    {
        return response()->json(['success' => $interval->delete()]);
    }
}
