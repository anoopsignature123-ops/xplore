<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuilderServiceType extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * Builders who have selected this service type.
     */
    public function builderServices()
    {
        return $this->hasMany(BuilderService::class, 'service_type_id');
    }

    /**
     * Scope: only active types.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
