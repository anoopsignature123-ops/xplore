<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOrder extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'product_orders';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    protected $fillable = [
        'order_number',
        'user_id',
        'order_type',
        'rel_id',
        'customer_name', 
        'customer_mobile',
        'customer_email',
        'address_type',
        'address',
        'city_name',
        'state_name',
        'pincode',
        'subtotal',
        'tax',
        'tax_percentage',
        'grand_total',
        'payment_status',
        'order_status',
        'notes',
    ];

    public function items()
    {
        return $this->hasMany(ProductOrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}