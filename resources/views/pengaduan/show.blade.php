<x-app-layout>
    <div class="container mx-auto px-6 py-8 max-w-5xl">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">
            Detail Pengaduan #{{ $pengaduan->ticket_number }}
        </h2>

        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-6">

                <!-- Detail pengaduan -->
                <x-detail-item label="Nomor Tiket" :value="$pengaduan->ticket_number ?? '-'" />
                <x-detail-item label="Nama Pengguna" :value="$pengaduan->user->name ?? '-'" />
                <x-detail-item label="Jenis Laporan" :value="$pengaduan->jenis_laporan ?? '-'" />
                <x-detail-item label="Nomor Telepon" :value="$pengaduan->phone ?? '-'" />
                <x-detail-item label="Tanggal" :value="\Carbon\Carbon::parse($pengaduan->created_at)->format('d-m-Y H:i')" />
                <x-detail-item label="Lokasi" :value="$pengaduan->lokasi ?? '-'" />

                <div class="lg:col-span-2">
                    <h3 class="text-sm font-semibold text-gray-600 mb-1">Keterangan</h3>
                    <p class="text-gray-800 whitespace-pre-line">{{ $pengaduan->keterangan ?? '-' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-200 py-2">
                    <div class="flex flex-col">
                        <h3 class="text-sm font-semibold text-gray-600 mb-1">Kategori</h3>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $pengaduan->kategori_class }}">
                            {{ $pengaduan->kategori_label }}
                        </span>
                    </div>

                    <div class="flex flex-col items-end">
                        <h3 class="text-sm font-semibold text-gray-600 mb-1">Status</h3>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $pengaduan->status_class }}">
                            {{ $pengaduan->status_label }}
                        </span>
                    </div>
                </div>

                {{-- View Gambar dan PDF --}}
                <div class="lg:col-span-2 mt-4">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">File Lampiran</h3>

                    @if ($pengaduan->file_url)
                        <div class="border rounded-md p-3 bg-gray-50 text-center">
                            @if (in_array($pengaduan->file_ext, ['jpg', 'jpeg', 'png']))
                                <a href="{{ $pengaduan->file_url }}" target="_blank">
                                    <img src="{{ $pengaduan->file_url }}" class="max-h-80 mx-auto object-contain" />
                                </a>
                            @elseif ($pengaduan->file_ext === 'pdf')
                                <iframe src="{{ $pengaduan->file_url }}" class="w-full h-96" frameborder="0"></iframe>
                            @else
                                <p class="text-red-500">
                                    File tidak dapat ditampilkan. Silakan
                                    <a href="{{ $pengaduan->file_url }}" download class="text-indigo-600 underline">unduh file</a>.
                                </p>
                            @endif

                            <p class="mt-2 text-sm text-gray-500">
                                <a href="{{ $pengaduan->file_url }}" download class="text-indigo-600 underline">Unduh file</a>
                            </p>
                        </div>
                    @else
                        <p class="text-gray-400 italic">Tidak ada file lampiran.</p>
                    @endif
                </div>


            </div>

            <!-- Tombol Kembali dan Edit -->
            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('pengaduan.history') }}"
                   class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                    Kembali
                </a>

                @if ($pengaduan->status === 'pending')
                    <a href="{{ route('pengaduan.edit', $pengaduan) }}"
                       class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                        Edit Pengaduan
                    </a>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
