<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyChat extends Model
{
    use HasFactory, SoftDeletes;
    use LogsActivity;

    protected $table = 'survey_chats';

    protected $fillable = [
        'customer_survey_id',
        'sender_type',
        'sender_id',
        'message',
        'attachment_path',
        'attachment_type',
        'read_at'
    ];

    public function customerSurvey()
    {
        return $this->belongsTo(CustomerSurvey::class, 'customer_survey_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}