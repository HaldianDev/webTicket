<x-app-layout>
    <div class="flex">
        <main class="flex-1 p-6 bg-gray-50 min-h-screen">
            <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md border border-blue-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Riwayat Pengaduan</h2>

                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('pengaduan.history') }}" class="mb-4 flex justify-end">
                    <input type="text" name="search" placeholder="Cari tiket, kategori, keterangan..."
                           value="{{ request('search') }}"
                           class="border border-gray-300 rounded px-4 py-2 mr-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Cari
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nomer Tiket</th>
                                <th class="px-4 py-2 border">Jenis Laporan</th>
                                <th class="px-4 py-2 border">Keterangan</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Aksi</th> <!-- Kolom baru -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengaduans as $index => $item)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>

                                    {{-- NOMER TIKET --}}
                                    <td class="px-4 py-2 border">{{ $item->ticket_number }}</td>

                                    {{-- JENIS LAPORAN --}}
                                    <td class="px-4 py-2 border">{{ $item->jenis_laporan }}</td>

                                    {{-- KETERANGAN --}}
                                    <td class="px-4 py-2 border">{{ $item->keterangan }}</td>

                                    {{-- STATUS --}}
                                    <td class="px-4 py-2 border">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $item->status_class }}">
                                            {{ $item->status_label }}
                                        </span>
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="px-4 py-2 border">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}
                                    </td>


                                    {{-- AKSI: Tombol Detail --}}
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route('pengaduan.show', $item) }}"
                                           class="inline-block px-3 py-1 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-gray-500">Belum ada pengaduan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
