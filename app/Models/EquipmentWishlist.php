<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentWishlist extends Model
{
    protected $fillable = [
        'customer_id',
        'equipment_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
