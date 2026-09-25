<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function builders()
    {
        return $this->hasMany(Builder::class, 'category_id');
    }
}
