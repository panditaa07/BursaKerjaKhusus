<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    // Tampilkan daftar lowongan di dashboard
    public function index()
    {
        $lowongans = Lowongan::latest()->get();
        return view('dashboard.lowongan.index', compact('lowongans'));
    }
}
