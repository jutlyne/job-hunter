<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'experience',
        'year_of_birth',
        'education',
        'language',
        'quote'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
