<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganAktif extends Model
{
    use HasFactory;

    protected $fillable = [
        'perusahaan',
        'no_hrd',
        'alamat',
        'status'
    ];
}
