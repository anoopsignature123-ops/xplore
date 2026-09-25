<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuilderCompletedProject extends Model
{
    protected $fillable = [
        'builder_id',
        'project_title',
        'location',
        'area_details',
        'image',
    ];

    public function builder()
    {
        return $this->belongsTo(Builder::class, 'builder_id');
    }
}
