<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'description',
        'address',
        'phone',
        'is_verified',
        'logo',
        'website',
        'industry_id'
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function jobPosts() { return $this->hasMany(JobPost::class); }
    public function industry() { return $this->belongsTo(Industry::class); }
}
