<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildServiceFaq extends Model
{
    protected $fillable = ['build_service_id', 'question', 'answer', 'sort_order'];

    public function service()
    {
        return $this->belongsTo(BuildService::class, 'build_service_id');
    }
}
