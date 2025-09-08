<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',   // relasi ke perusahaan
        'judul',
        'deskripsi',
        'lokasi',
        'gaji',
        'batas_akhir',
        'status'        // contoh: aktif / tidak_aktif
    ];

    /**
     * Relasi: Lowongan dimiliki oleh sebuah Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relasi: Lowongan punya banyak Lamaran
     */
    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}
