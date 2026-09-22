<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseContent extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'topic_id',
        'type',
        'name',
        'pdf',
        'status',
        'video_id',
        'priority' 
    ];

    public function topic()
    {
        return $this->belongsTo(CourseTopic::class,'topic_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}