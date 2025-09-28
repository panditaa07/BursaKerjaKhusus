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
        'description',
        'address',
        'phone',
        'is_verified',
        'logo'
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function jobPosts() { return $this->hasMany(JobPost::class); }
}
