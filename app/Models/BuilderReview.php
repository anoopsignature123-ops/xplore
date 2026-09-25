<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuilderReview extends Model
{
    protected $fillable = [
        'builder_id',
        'customer_id',
        'customer_name',
        'customer_image',
        'rating',
        'review_text',
        'status',
    ];

    protected $casts = [
        'rating' => 'float',
        'status' => 'boolean',
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
