<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $full_name
 * @property string|null $function
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property EmployeeSettings $settings
 */
class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'email',
        'available',
        'function',
    ];

    public function settings(): HasOne
    {
        return $this->hasOne(EmployeeSettings::class);
    }
}
