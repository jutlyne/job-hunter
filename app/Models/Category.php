<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function blogCategories()
    {
        return $this->hasMany(BlogCategory::class, 'category_id');
    }

    public function getCountBlogAttribute()
    {
        return $this->blogCategories->count();
    }
}
