<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tutorial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    /**
     * Tampilkan semua tutorial.
     */
    public function index()
    {
        $tutorials = Tutorial::latest()->get();

        // Parsing videoId untuk tiap tutorial agar tidak ada logic di view
        $tutorials->transform(function ($tutorial) {
            $videoId = null;
            if (preg_match('/v=([^&]+)/', $tutorial->youtube_url, $matches)) {
                $videoId = $matches[1];
            }
            $tutorial->videoId = $videoId;
            return $tutorial;
        });

        return view('admin.tutorials.index', compact('tutorials'));
    }


    /**
     * Tampilkan form tambah tutorial.
     */
    public function create()
    {
        return view('admin.tutorials.create');
    }

    /**
     * Simpan data tutorial baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validateTutorial($request);

        Tutorial::create($validated);

        return redirect()->route('admin.tutorials.index')->with('success', 'Tutorial berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit tutorial.
     */
    public function edit(Tutorial $tutorial)
    {
        return view('admin.tutorials.edit', compact('tutorial'));
    }

    /**
     * Perbarui data tutorial.
     */
    public function update(Request $request, Tutorial $tutorial)
    {
        $validated = $this->validateTutorial($request);

        $tutorial->update($validated);

        return redirect()->route('admin.tutorials.index')->with('success', 'Tutorial berhasil diperbarui.');
    }

    /**
     * Hapus tutorial.
     */
    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();

        return redirect()->route('admin.tutorials.index')->with('success', 'Tutorial berhasil dihapus.');
    }

    /**
     * Validasi data tutorial.
     */
    private function validateTutorial(Request $request): array
    {
        return $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'youtube_url'  => 'required|url',
        ]);
    }
}
