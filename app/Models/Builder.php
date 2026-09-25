<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Builder extends Authenticatable
{
    use SoftDeletes, Notifiable, LogsActivity;

    protected $table = 'builders';

    protected $fillable = [
        'category_id',
        'name',
        'firm_name',
        'slug',
        'email',
        'password',
        'phone',
        'profile_image',
        'cover_image',
        'location',
        'address',
        'website',
        'about',
        'experience_years',
        'projects_count',
        'rating',
        'is_verified',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'experience_years' => 'integer',
        'projects_count'   => 'integer',
        'rating'           => 'float',
        'is_verified'      => 'boolean',
        'status'           => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(BuildCategory::class, 'category_id');
    }

    public function services()
    {
        return $this->hasMany(BuilderService::class, 'builder_id');
    }

    public function certifications()
    {
        return $this->hasMany(BuilderCertification::class, 'builder_id');
    }

    public function serviceAreas()
    {
        return $this->hasMany(BuilderServiceArea::class, 'builder_id');
    }

    public function portfolios()
    {
        return $this->hasMany(BuilderPortfolio::class, 'builder_id');
    }

    public function completedProjects()
    {
        return $this->hasMany(BuilderCompletedProject::class, 'builder_id');
    }

    public function reviews()
    {
        return $this->hasMany(BuilderReview::class, 'builder_id');
    }

    public function inquiries()
    {
        return $this->hasMany(BuilderInquiry::class, 'builder_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
