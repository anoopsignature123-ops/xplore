<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ContactUs extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'contact_us';

    protected $fillable = [
        'customer_id',
        'contact_type_id',
        'name',
        'email',
        'phone',
        'type',
        'title',
        'message',
        'reply',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function contactType()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }
}
