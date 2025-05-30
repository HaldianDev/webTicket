<x-app-layout>
    <div x-data="{ sidebarOpen: true }" class="flex">
        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-50 min-h-screen">

            <!-- Form Input -->
            <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md border border-blue-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Form Input Pengaduan</h2>

                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="kategori" class="block text-gray-700 font-medium mb-2">Kategori</label>
                        <input type="text" id="kategori" name="kategori" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Jenis Laporan -->
                    <div class="mb-4">
                        <label for="jenis_laporan" class="block text-gray-700 font-medium mb-2">Jenis Laporan</label>
                        <select id="jenis_laporan" name="jenis_laporan" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="insiden_cyber">Insiden Cyber</option>
                            <option value="laporan_bug">Laporan Bug</option>
                            <option value="laporan_permasalahan">Laporan Permasalahan</option>
                        </select>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan" class="block text-gray-700 font-medium mb-2">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="4" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>


                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-4">
                        <label for="lokasi" class="block text-gray-700 font-medium mb-2">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- File -->
                    <div class="mb-4">
                        <label for="file" class="block text-gray-700 font-medium mb-2">Unggah File</label>
                        <input type="file" id="file" name="file" class="w-full">
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Kirim</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
