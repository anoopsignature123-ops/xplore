<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuilderServiceArea extends Model
{
    protected $fillable = [
        'builder_id',
        'city_name',
    ];

    public function builder()
    {
        return $this->belongsTo(Builder::class, 'builder_id');
    }
}
