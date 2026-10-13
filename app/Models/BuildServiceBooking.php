<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildServiceBooking extends Model
{
    protected $fillable = [
        'build_service_id', 'customer_id', 'customer_name',
        'site_location', 'contact_mobile', 'target_timeline',
        'budget_range', 'project_notes', 'status', 'admin_notes',
    ];

    public function service()
    {
        return $this->belongsTo(BuildService::class, 'build_service_id');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'customer_id');
    }
}
