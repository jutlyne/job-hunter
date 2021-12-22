<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class Employer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'twitter',
        'youtube',
        'instagram',
        'facebook',
        'email',
        'address',
        'phone',
        'description',
        'province_id',
        'district_id',
        'latitude',
        'longitude',
        'thumbnail',
        'avatar',
        'status',
        'owner',
        'prioritize',
        'prioritize_at'
    ];

    protected $appends = ['rating', 'thumbnail_url', 'avatar_url', 'avg_rating'];

    public function staffs()
    {
        return $this->hasMany(Staff::class, 'employer_id', 'id');
    }

    public function recruitment()
    {
        return $this->hasMany(Recruitment::class, 'employer_id', 'id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'employer_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function getAvatarUrlAttribute()
    {
        return ($this->thumbnail) ? Storage::disk('s3')->url($this->avatar) : asset('img/default_company.jpg');
    }

    public function getThumbnailUrlAttribute()
    {
        return ($this->thumbnail) ? Storage::disk('s3')->url($this->thumbnail) : asset('img/default_company.jpg');
    }

    public function images()
    {
        return $this->hasMany(EmployerImage::class, 'employer_id', 'id');
    }

    public function applies()
    {
        return $this->hasMany(Application::class);
    }
}
