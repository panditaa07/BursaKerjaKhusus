<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Company extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'description',
        'address',
        'phone',
        'is_verified',
        'logo',
        'industry_id',
        'status',
        'social_media',
        'linkedin',
        'facebook',
        'twitter',
        'tiktok',
        'youtube',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function jobPosts() { return $this->hasMany(JobPost::class); }
    public function industry() { return $this->belongsTo(Industry::class); }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\CompanyResetPasswordNotification($token));
    }
}
