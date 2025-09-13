<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * @method \Illuminate\Database\Eloquent\Relations\MorphMany notifications()
 */
class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cv_path',
        'company_id',
        'role_id',
        'phone',
        'address',
        'nisn',
        'company_name',
        'birth_date',
        'short_profile',
        'social_media_link',
        'facebook',
        'instagram',
        'linkedin',
        'twitter',
        'tiktok',
        'profile_photo_path',
    ];

    /**
     * Relasi ke perusahaan
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Relasi ke lamaran
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Relasi ke role (belongsTo)
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relasi ke notifications (morphMany)
     */

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

    public function notifications()
{
    return $this->hasMany(UserNotification::class);
}

}
