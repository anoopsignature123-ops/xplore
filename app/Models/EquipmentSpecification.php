<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentSpecification extends Model
{
    protected $fillable = [
        'equipment_id',
        'spec_key',
        'spec_value',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
