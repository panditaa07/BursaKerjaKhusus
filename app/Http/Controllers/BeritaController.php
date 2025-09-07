<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{


    public function index()
    {
        $beritas = Berita::with('user')->latest()->paginate(6);
        return view('berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul) . '-' . time();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('berita', 'public');
            $data['foto'] = $path;
        }

        Berita::create($data);

        $dashboardRoute = match(auth()->user()->role ?? 'user') {
            'admin' => 'admin.dashboard.index',
            'company' => 'company.dashboard.index',
            default => 'user.dashboard.index',
        };

        return redirect()->route($dashboardRoute)->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    public function destroy(Berita $berita)
    {
        // Hapus foto jika ada
        if ($berita->foto) {
            Storage::disk('public')->delete($berita->foto);
        }
        
        $berita->delete();
        
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}
