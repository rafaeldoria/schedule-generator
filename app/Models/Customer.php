<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $full_name
 * @property string|null $cellphone
 * @property string|null $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property ScheduleDetails $scheduleDetails
 */

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'email',
        'cellphone',
    ];

    public function scheduleDetailss(): HasMany
    {
        return $this->hasMany(ScheduleDetails::class);
    }
}
