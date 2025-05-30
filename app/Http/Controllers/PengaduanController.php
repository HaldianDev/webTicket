<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Pengaduan; // Pastikan model Pengaduan sudah dibuat
use Illuminate\Support\Facades\DB;


class PengaduanController extends Controller
{
    public function index()
    {
        return view('form-ticket');
    }


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_laporan' => 'required|in:insiden,bug',
            'kategori'      => 'required|string|max:255',
            'keterangan'    => 'required|string',
            'phone'         => 'required|string|max:20',
            'lokasi'        => 'required|string|max:255',
            'file'          => 'nullable|file|max:2048',
        ]);


        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('pengaduan_files', 'public');
        }

        // Simpan ke database
        DB::table('pengaduans')->insert([
            'jenis_laporan' => $validated['jenis_laporan'],
            'kategori'      => $validated['kategori'],
            'keterangan'    => $validated['keterangan'],
            'phone'         => $validated['phone'],
            'lokasi'        => $validated['lokasi'],
            'file_path'     => $validated['file_path'] ?? null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);


        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function history()
    {
        $pengaduans = DB::table('pengaduans')->orderBy('created_at', 'desc')->get();

        return view('history', compact('pengaduans'));
    }

}
