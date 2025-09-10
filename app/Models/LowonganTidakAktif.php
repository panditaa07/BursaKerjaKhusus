<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganTidakAktif extends Model
{
    use HasFactory;

    protected $fillable = [
        'perusahaan',
        'no_hrd',
        'alamat',
        'status'
    ];
}
