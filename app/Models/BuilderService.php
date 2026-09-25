<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuilderService extends Model
{
    protected $fillable = [
        'builder_id',
        'service_name',
    ];

    public function builder()
    {
        return $this->belongsTo(Builder::class, 'builder_id');
    }
}
