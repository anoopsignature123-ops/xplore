<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EquipmentBooking extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'booking_number',
        'customer_id',
        'equipment_id',
        'rental_duration_days',
        'daily_rate',
        'rental_cost',
        'security_deposit',
        'gst_amount',
        'total_amount',
        'delivery_type',
        'address_id',
        'latitude',
        'longitude',
        'delivery_address',
        'booking_status',
        'payment_status',
        'payment_method',
        'razorpay_order_id',
        'razorpay_payment_id',
    ];

    protected $casts = [
        'rental_duration_days' => 'integer',
        'daily_rate' => 'float',
        'rental_cost' => 'float',
        'security_deposit' => 'float',
        'gst_amount' => 'float',
        'total_amount' => 'float',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function address()
    {
        return $this->belongsTo(CustomerAddress::class, 'address_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
