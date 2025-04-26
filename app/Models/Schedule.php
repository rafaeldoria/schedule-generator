<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $generated_schedule
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Employee $employee
 * @property ScheduleDetails $scheduleDetails
 */

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'generated_schedule',
        'employee_id',
        'status',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function scheduleDetails(): HasMany
    {
        return $this->hasMany(ScheduleDetails::class);
    }
}
