<x-app-layout>
    <div x-data="{ sidebarOpen: true }" class="flex">
        <main class="flex-1 p-6 bg-gray-50 min-h-screen">
            <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md border border-blue-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Form Input Pengaduan</h2>

                <!-- Form Input -->
                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="kategori" class="block text-gray-700 font-medium mb-2">Kategori</label>
                        <select id="kategori" name="kategori"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="low" {{ old('kategori') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('kategori') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('kategori') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <!-- Jenis Laporan -->
                    {{-- <div class="mb-4">
                        <label for="jenis_laporan" class="block text-gray-700 font-medium mb-2">Jenis Laporan</label>
                        <input type="text" id="jenis_laporan" name="jenis_laporan"
                               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ request()->query('nama_layanan', old('jenis_laporan')) }}"
                               required>
                    </div> --}}

                    <div class="mb-4">
                        <label for="jenis_laporan" class="block text-gray-700 font-medium mb-2">Jenis Laporan</label>
                        <select id="jenis_laporan" name="jenis_laporan"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="">-- Pilih Jenis Laporan --</option>
                            <option value="milik_sendiri" {{ (request()->query('jenis_laporan') ?? old('jenis_laporan')) == 'milik_sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                            <option value="milik_orang_lain" {{ (request()->query('jenis_laporan') ?? old('jenis_laporan')) == 'milik_orang_lain' ? 'selected' : '' }}>Milik Orang Lain</option>
                        </select>
                    </div>


                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan" class="block text-gray-700 font-medium mb-2">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="4"
                                  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  required>{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Nik Number -->
                    <div class="mb-4">
                        <label for="nik" class="block text-gray-700 font-medium mb-2">Nomor NIK</label>
                        <input type="text" id="nik" name="nik"
                               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('nik') }}"
                               required>
                    </div>

                    <!-- Type -->
                    {{-- <div class="mb-4">
                        <label for="type" class="block text-gray-700 font-medium mb-2">type</label>
                        <input type="text" id="type" name="type"
                               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('type') }}"
                               required>
                    </div> --}}
                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                        <select id="type" name="type"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="">-- Pilih Platform --</option>
                            <option value="android" {{ old('type') == 'android' ? 'selected' : '' }}>Android</option>
                            <option value="ios" {{ old('type') == 'ios' ? 'selected' : '' }}>iOS</option>
                        </select>
                    </div>

                    <!-- File -->
                    <div class="mb-4">
                        <label for="file" class="block text-gray-700 font-medium mb-2">Unggah File</label>
                        <input type="file" id="file" name="file" class="w-full">
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>

