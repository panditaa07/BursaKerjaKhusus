<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelamar',
        'email',
        'no_hp',
        'perusahaan',
        'lowongan',
        'cv',
        'status',
    ];

    public $timestamps = true;

    // Relasi ke User (pelamar)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Loker (lowongan kerja)
    public function loker()
    {
        return $this->belongsTo(Loker::class);
    }
}
