<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cv_path',
        'company_id',
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
     * Relasi ke roles (pivot role_user)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Cek apakah user punya role tertentu
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Tambah role ke user
     */
    public function assignRole($roleId)
    {
        return $this->roles()->attach($roleId);
    }

    /**
     * Hapus role dari user
     */
    public function removeRole($roleId)
    {
        return $this->roles()->detach($roleId);
    }

    /**
     * Sinkronisasi role (replace semua role lama)
     */
    public function syncRoles(array $roleIds)
    {
        return $this->roles()->sync($roleIds);
    }

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
}