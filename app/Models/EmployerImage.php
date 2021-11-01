<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EmployerImage extends Model
{
    use HasFactory;

    protected $fillable = ['employer_id', 'url'];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->attributes['url']);
    }
}
