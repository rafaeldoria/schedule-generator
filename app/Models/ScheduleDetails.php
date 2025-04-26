<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $start_time
 * @property string|null $end_time
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Schedule $schedule
 * @property Customer $customer
 */
class ScheduleDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'time',
        'status',
        'schedule_id',
        'customer_id',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }
}
