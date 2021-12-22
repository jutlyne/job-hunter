<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'thumbnail',
        'seo_title',
        'seo_description',
        'seo_keyword',
        'status',
        'breadcrumb_seo_keyword',
        'img_content'
    ];

    public function blogCategories()
    {
        return $this->hasMany(BlogCategory::class);
    }

    public function getBlogUrlAttribute()
    {
        return ($this->attributes['thumbnail']) ? Storage::disk()->url($this->attributes['thumbnail']) : '';
    }

}
