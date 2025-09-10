<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarBulanIni extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelamar',
        'email',
        'no_hp',
        'perusahaan',
        'status',
    ];
}
