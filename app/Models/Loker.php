<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    use HasFactory;

    protected $table = 'lokers'; // pastikan sama dengan nama tabel di DB
    protected $fillable = [
        'company_id',
        'judul',
        'deskripsi',
        'no_hrd',
        'alamat',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
