<div class="bg-white shadow-lg rounded-lg p-6 space-y-6">

    <div>
        <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan</label>
        <input type="text" name="nama_layanan" id="nama_layanan"
               value="{{ old('nama_layanan', $layanan->nama_layanan ?? '') }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('nama_layanan')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" rows="4"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none">{{ old('deskripsi', $layanan->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar (opsional)</label>
        <input type="file" name="gambar" id="gambar" accept="image/*"
               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('gambar')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

   <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.layanan.index') }}"
        class="inline-flex items-center justify-center px-6 py-2 bg-yellow-500 text-white font-semibold rounded-md shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition">
            Batal
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Simpan
        </button>
    </div>

</div>
