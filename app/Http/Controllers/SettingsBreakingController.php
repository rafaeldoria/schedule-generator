<?php

namespace App\Http\Controllers;

use App\Models\SettingsBreaking;
use Illuminate\Http\JsonResponse;

class SettingsBreakingController
{
    public function delete(SettingsBreaking $breaking): JsonResponse
    {
        return response()->json(['success' => $breaking->delete()]);
    }
}
