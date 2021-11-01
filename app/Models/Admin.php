<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'password',
        'avatar',
        'title',
        'description'
    ];

    protected $appends = ['avatar_url'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getAvatarUrlAttribute()
    {
        return isset($this->avatar) ? Storage::disk('public')->url($this->avatar) : null;
    }

    public function role()
    {
        return 'admin';
    }
}
