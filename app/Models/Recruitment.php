<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Recruitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'preview_text',
        'gender',
        'benefit_text',
        'profile_text',
        'province_id',
        'category_id',
        'qty',
        'employer_id',
        'thumbnail'
    ];

    public function getRecruitmentUrlAttribute()
    {
        return ($this->attributes['thumbnail']) ? Storage::disk('public')->url($this->attributes['thumbnail']) : '';
    }

    public function recruitmentCategories()
    {
        return $this->hasMany(RecruitmentCategory::class);
    }

    public function category()
    {
        return $this->belongsTo(RecruitmentCategory::class, 'category_id', 'id');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function applies()
    {
        return $this->hasMany(Application::class);
    }
}
