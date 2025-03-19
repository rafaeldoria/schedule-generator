<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $start_time
 * @property string $end_time
 * @property int $settings_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class SettingsInterval extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'settings_id',
    ];

    public function settings(): BelongsTo
    {
        return $this->belongsTo(EmployeeSettings::class);
    }
}
