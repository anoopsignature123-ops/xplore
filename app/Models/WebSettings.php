<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Database\Eloquent\Model;

class WebSettings extends Model
{
    use LogsActivity;
    protected $table = 'web_settings';

    protected $fillable = [ 
        'company_name',
        'email_id',
        'phone_no',
        'whatsapp_no',
        'facebook_link', 
        'youtube_link',
        'instagram_link',
        'twitter_link',
        'copyright',
        'logo',
        'favicon',
        'address',
        'qr_image',
        'sign_image',
        'stamp_image'
    ];

  



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}