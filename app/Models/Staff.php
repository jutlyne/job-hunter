<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'employer_id',
        'phone',
        'email',
        'name',
        'password',
        'avatar',
        'phone_verified_at',
        'password_verified_at',
        'verification_code',
        'reset_password_code',
        'device_id',
        'recover_pass'
    ];

    protected $appends = ['avatar_url'];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'staff_id', 'id');
    }

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
        return 'employer';
    }
}
