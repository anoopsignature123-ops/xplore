<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildService extends Model
{
    protected $fillable = [
        'category_id', 'title', 'short_desc', 'price', 'price_type',
        'duration', 'rating', 'total_reviews', 'tags', 'overview',
        'deliverables', 'what_you_get', 'execution_steps', 'sort_order', 'status',
    ];

    protected $casts = [
        'tags'            => 'array',
        'deliverables'    => 'array',
        'what_you_get'    => 'array',
        'execution_steps' => 'array',
        'price'           => 'float',
        'rating'          => 'float',
        'status'          => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(BuildCategory::class, 'category_id');
    }

    public function faqs()
    {
        return $this->hasMany(BuildServiceFaq::class, 'build_service_id')->orderBy('sort_order');
    }

    public function bookings()
    {
        return $this->hasMany(BuildServiceBooking::class, 'build_service_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Formatted price label: "₹2,499 fixed" or "₹1,650 / sq.ft"
     */
    public function getPriceLabelAttribute(): string
    {
        $formatted = '₹' . number_format($this->price, 0);
        return match ($this->price_type) {
            'per_sqft' => $formatted . ' / sq.ft',
            'per_unit' => $formatted . ' / unit',
            default    => $formatted . ' fixed',
        };
    }
}
