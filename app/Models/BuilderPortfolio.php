<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuilderPortfolio extends Model
{
    protected $fillable = [
        'builder_id',
        'title',
        'image_url',
    ];

    public function builder()
    {
        return $this->belongsTo(Builder::class, 'builder_id');
    }
}
