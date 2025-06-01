<div class="bg-white shadow-lg rounded-lg p-6 space-y-6">
    <div class="mb-4">
        <label class="block mb-1 font-semibold">Judul</label>
        <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $tutorial->title) }}" required>
        @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Deskripsi</label>
        <textarea name="description" class="w-full border rounded px-3 py-2" required>{{ old('description', $tutorial->description) }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Link YouTube</label>
        <input type="url" name="youtube_url" class="w-full border rounded px-3 py-2" value="{{ old('youtube_url', $tutorial->youtube_url) }}" required>
        @error('youtube_url')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.tutorials.index') }}"
           class="inline-flex items-center justify-center px-6 py-2 bg-yellow-500 text-white font-semibold rounded-md shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition">
            Batal
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Simpan
        </button>
    </div>
</div>
