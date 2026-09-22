<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'course_category_id',
        'course_name',
        'image',
        'short_detail',
        'duration',
        'amount',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class,'course_category_id');
    }

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}