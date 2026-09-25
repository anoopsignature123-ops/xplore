<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuilderInquiry extends Model
{
    protected $fillable = [
        'builder_id',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'message',
        'inquiry_type',
        'status',
    ];

    public function builder()
    {
        return $this->belongsTo(Builder::class, 'builder_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
