<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model; 

class CustomerSurvey extends Model
{
    use LogsActivity;
    protected $fillable = [
        'customer_id',
        'survey_id',
        'vendor_id',
        'assigned_at',
        'latitude',
        'longitude',
        'survey_name',
        'survey_date',
        'survey_time',
        'amount',
        'address',
        'status',
        'payment_status',
        'cancel_reason',
    ];
 
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'rel_id')->where('order_type', 'survey');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}