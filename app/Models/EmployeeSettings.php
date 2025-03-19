<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $start_time
 * @property string $end_time
 * @property string|null $saturday_off
 * @property string|null $close_days
 * @property int $employee_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property SettingsInterval $intervalsT
 * @method static where(string $string, $employee_id)
 */
class EmployeeSettings extends Model
{
    protected $fillable = [
        'duration',
        'start_time',
        'end_time',
        'saturday_off',
        'close_days',
        'employee_id',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function intervalsT(): HasMany
    {
        return $this->hasMany(SettingsInterval::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($settings) {
            if (EmployeeSettings::where('employee_id', $settings->employee_id)->exists()) {
                throw new Exception('This employee already has a configuration.');
            }
        });
    }
}
