<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Model
{
    use HasApiTokens, SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'name',
        'phone_no',
        'profile_image',
        'otp',
        'otp_sent_at',
        'device_type',
        'device_id',
        'fcm_token',
        'email_id',
        'gender',
        'status',
    ];

    protected $casts = [
        'otp_sent_at' => 'datetime',
    ];

    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }
    


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}