<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LayananController extends Controller
{
    /**
     * Tampilkan semua layanan.
     */
    public function index()
    {
        $layanans = Layanan::all();
        return view('admin.layanan.index', compact('layanans'));
    }

    /**
     * Tampilkan form tambah layanan.
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /**
     * Simpan data layanan baru.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi'    => 'required|string',
            'gambar'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            // dd(Storage::disk('s3')->put('test.txt', 'coba upload ke minio'));
            $path = $file->store('layanan', 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $validated['gambar'] = $path;
        }

        Layanan::create($validated);

       return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit layanan.
     */
    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    /**
     * Perbarui data layanan.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi'    => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada di S3
            if ($layanan->gambar && Storage::disk('s3')->exists($layanan->gambar)) {
                Storage::disk('s3')->delete($layanan->gambar);
            }

            $file = $request->file('gambar');
            $path = $file->store('layanan', 's3'); // simpan ke S3
            Storage::disk('s3')->setVisibility($path, 'public');
            $validated['gambar'] = $path;
        }

        $layanan->update($validated);

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Hapus layanan.
     */
    public function destroy(Layanan $layanan)
    {
        if ($layanan->gambar && Storage::disk('s3')->exists($layanan->gambar)) {
            Storage::disk('s3')->delete($layanan->gambar);
        }

        $layanan->delete();

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
