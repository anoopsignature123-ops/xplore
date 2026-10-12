<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use SoftDeletes, Notifiable;
    use LogsActivity;

    protected $fillable = [
        'name',
        'email_id',
        'phone_no',
        'gender',
        'profile_image',
        'password',
        'raw_password',
        'status',
        'vendor_type',
        'gst_no',
        'pan_no',
        'proof_image',
        'kyc_status',
        'vendor_category_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function category()
    {
        return $this->belongsTo(VendorCategory::class, 'vendor_category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}