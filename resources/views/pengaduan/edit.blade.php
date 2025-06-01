<x-app-layout>
    <div x-data="{ sidebarOpen: true }" class="flex">
        <main class="flex-1 p-6 bg-gray-50 min-h-screen">
            <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md border border-blue-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Pengaduan #{{ $pengaduan->ticket_number }}</h2>

                <!-- Form Edit -->
                <form action="{{ route('pengaduan.update', $pengaduan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="kategori" class="block text-gray-700 font-medium mb-2">Kategori</label>
                        <select id="kategori" name="kategori"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="low" {{ $pengaduan->kategori == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $pengaduan->kategori == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $pengaduan->kategori == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <!-- Jenis Laporan -->
                    <div class="mb-4">
                        <label for="jenis_laporan" class="block text-gray-700 font-medium mb-2">Jenis Laporan</label>
                        <input type="text" id="jenis_laporan" name="jenis_laporan"
                               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ $pengaduan->jenis_laporan }}"
                               required readonly>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan" class="block text-gray-700 font-medium mb-2">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="4"
                                  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  required>{{ $pengaduan->keterangan }}</textarea>
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone"
                               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ $pengaduan->phone }}"
                               required>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-4">
                        <label for="lokasi" class="block text-gray-700 font-medium mb-2">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi"
                               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ $pengaduan->lokasi }}"
                               required>
                    </div>

                    <!-- File -->
                    <div class="mb-4">
                        <label for="file" class="block text-gray-700 font-medium mb-2">Unggah File Baru (opsional)</label>
                        <input type="file" id="file" name="file" class="w-full">
                        @if ($pengaduan->file_path)
                            <p class="mt-2 text-sm text-gray-600">
                                File lama:
                                <a href="{{ asset('storage/' . $pengaduan->file_path) }}" target="_blank" class="text-blue-600 underline">
                                    Lihat / Download
                                </a>
                            </p>
                        @endif
                    </div>

                    <!-- Tombol -->
                    <div class="mt-6 flex items-center space-x-4">
                        <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('pengaduan.show', $pengaduan) }}"
                           class="text-gray-600 hover:underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Success
            @if(session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: {!! json_encode(session('success')) !!},
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            // Validation Errors
            @if($errors->any())
                let errorsHtml = '<ul style="text-align: left;">';
                @foreach($errors->all() as $error)
                    errorsHtml += '<li>{{ addslashes($error) }}</li>';
                @endforeach
                errorsHtml += '</ul>';
                Swal.fire({
                    title: 'Terjadi Kesalahan',
                    html: errorsHtml,
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                });
            @endif
        });

        // Konfirmasi Hapus
        function confirmHapus(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data layanan akan hilang permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
            return false;
        }
    </script>
