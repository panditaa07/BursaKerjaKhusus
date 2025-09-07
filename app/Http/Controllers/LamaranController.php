<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use Illuminate\Http\Request;

class LamaranController extends Controller
{
    public function index()
    {
        $lamarans = Lamaran::latest()->get();
        return view('company.applications.index', compact('lamarans'));
    }

    public function create()
    {
        return view('company.applications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelamar' => 'required|string|max:255',
            'lowongan' => 'required|string|max:255',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public');
        }

        Lamaran::create([
            'nama_pelamar' => $request->nama_pelamar,
            'lowongan' => $request->lowongan,
            'cv' => $cvPath,
            'status' => 'pending',
        ]);

        return redirect()->route('lamarans.index')->with('success', 'Lamaran berhasil ditambahkan!');
    }

    public function show($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        return view('company.applications.show', compact('lamaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $lamaran->status = $request->status;
        $lamaran->save();

        return redirect()->route('lamarans.index')->with('success', 'Status lamaran diperbarui.');
    }


    public function destroy($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $lamaran->delete();

        return redirect()->route('lamarans.index')->with('success', 'Lamaran berhasil dihapus.');
    }
}
