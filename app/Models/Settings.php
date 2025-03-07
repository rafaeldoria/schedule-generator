<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $start_time
 * @property string $end_time
 * @property string|null $intervals
 * @property string|null $saturday_off
 * @property string|null $close_days
 * @property int $employee_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Settings extends Model
{
    protected $fillable = [
        'duration',
        'start_time',
        'end_time',
        'intervals',
        'saturday_off',
        'close_days',
        'employee_id',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
