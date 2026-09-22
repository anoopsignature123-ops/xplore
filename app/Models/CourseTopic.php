<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTopic extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'lesson_id',
        'topic_name',
        'priority',
        'status'
    ]; 

    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class,'lesson_id');
    }

    public function contents()
    {
        return $this->hasMany(CourseContent::class,'topic_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}