<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Equipment extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'brand',
        'model',
        'accuracy',
        'availability_status',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'security_deposit',
        'gst_percentage',
        'is_popular',
        'status',
    ];

    protected $casts = [
        'daily_rate' => 'float',
        'weekly_rate' => 'float',
        'monthly_rate' => 'float',
        'security_deposit' => 'float',
        'gst_percentage' => 'float',
        'is_popular' => 'boolean',
        'status' => 'boolean',
    ];

    public function specifications()
    {
        return $this->hasMany(EquipmentSpecification::class, 'equipment_id');
    }

    public function bookings()
    {
        return $this->hasMany(EquipmentBooking::class, 'equipment_id');
    }

    public function wishlists()
    {
        return $this->hasMany(EquipmentWishlist::class, 'equipment_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
