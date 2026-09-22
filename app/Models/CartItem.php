<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'mrp_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'product_name',
        'variant_name',
        'category_name',
        'sub_category_name',
        'brand_name',
        'mrp_price',
        'sale_price',
        'quantity',
        'line_total',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}