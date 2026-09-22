<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSpecification extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'product_id',
        'name',
        'value',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
 
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}