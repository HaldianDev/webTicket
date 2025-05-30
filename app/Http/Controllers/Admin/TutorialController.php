<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tutorial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::latest()->get();
        return view('admin.tutorials.index', compact('tutorials'));
    }

    public function create()
    {
        return view('admin.tutorials.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateTutorial($request);

        Tutorial::create($validated);

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil ditambahkan');
    }

    public function edit(Tutorial $tutorial)
    {
        return view('admin.tutorials.edit', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $validated = $this->validateTutorial($request);

        $tutorial->update($validated);

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil diupdate');
    }

    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil dihapus');
    }

    private function validateTutorial(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'youtube_url' => 'required|url',
        ]);
    }
}
