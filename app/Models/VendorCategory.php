<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class VendorCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'vendor_categories';

    protected $fillable = [
        'name',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'vendor_category_id');
    }
}
