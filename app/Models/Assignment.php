<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => 'string',
    ];

    protected $dates = ['deleted_at'];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

    // Status options for dropdowns
    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_COMPLETED => 'Completed',
        ];
    }

    // Get status badge class for styling
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'badge badge-warning',
            self::STATUS_ACTIVE => 'badge badge-primary',
            self::STATUS_COMPLETED => 'badge badge-success',
            default => 'badge badge-secondary',
        };
    }

    // Check if assignment is pending
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Check if assignment is active
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    // Check if assignment is completed
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    function workplace()
    {
        return $this->belongsTo(Workplace::class);
    }

    function task()
    {
        return $this->belongsTo(Task::class);
    }
}
