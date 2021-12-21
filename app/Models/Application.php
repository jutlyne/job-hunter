<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'recruitment_id',
        'user_id',
        'employer_id',
        'status',
        'cancel_text',
        'apply_text',
        'apply_date',
        'zoom_url',
        'due_at',
        'zoom_id',
        'zoom_password'
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
