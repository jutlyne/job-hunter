<?php

namespace App\Models;

use App\Traits\MustVerifyPhone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, MustVerifyPhone;

    protected $fillable = [
        'email',
        'provider',
        'provider_id',
        'email_md5',
        'phone',
        'name',
        'password',
        'provider',
        'provider_id',
        'phone_verified_at',
        'password_verified_at',
        'verification_code',
        'avatar',
        'address',
        'reset_password_code',
        'province_id',
        'district_id',
        'device_id',
        'ads',
        'status'
    ];

    protected $appends = ['avatar_url'];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function getAvatarUrlAttribute()
    {
        return isset($this->avatar) ? Storage::disk()->url($this->avatar) : asset('img/default_user_banner.png');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function applies()
    {
        return $this->hasMany(Application::class);
    }

    public function role()
    {
        return 'user';
    }
}
