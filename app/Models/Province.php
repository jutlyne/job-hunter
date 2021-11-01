<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function employers()
    {
        return $this->hasMany(Employer::class, 'province_id', 'id');
    }

    public function recruitment()
    {
        return $this->hasMany(Recruitment::class, 'province_id', 'id');
    }
}
