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

                <div class="lg:col-span-2 mt-4">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">File Lampiran</h3>
                    @if ($pengaduan->file_path)
                        <div class="border rounded-md p-3 bg-gray-50 text-center">
                            <a href="{{ asset('storage/' . $pengaduan->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $pengaduan->file_path) }}" class="max-h-80 mx-auto object-contain" />
                            </a>
                            <p class="mt-2 text-sm text-gray-500">
                                Klik gambar untuk melihat atau
                                <a href="{{ asset('storage/' . $pengaduan->file_path) }}" download class="text-indigo-600 underline">unduh file</a>.
                            </p>
                        </div>
                    @else
                        <p class="text-gray-400 italic">Tidak ada file lampiran.</p>
                    @endif
                </div>
            </div>

            <!-- Komentar -->
            <div class="mt-10 border-t pt-6">
                <h3 class="text-xl font-semibold mb-4">Komentar</h3>

                @foreach ($pengaduan->comments as $comment)
                    <div class="mb-3 p-4 rounded-md {{ $comment->user_id === auth()->id() ? 'bg-blue-50' : 'bg-gray-100' }}">
                        <p class="text-sm text-gray-600">
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="text-xs text-gray-500">({{ $comment->created_at->diffForHumans() }})</span>
                        </p>
                        <p class="text-gray-800 mt-1">{{ $comment->message }}</p>
                    </div>
                @endforeach

                <form method="POST" action="{{ route('pengaduan.comment', $pengaduan) }}" class="mt-4">
                    @csrf
                    <textarea name="message" rows="3" required
                              class="w-full p-3 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300"
                              placeholder="Tulis komentar..."></textarea>
                    <div class="mt-2 text-right">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Kirim
                        </button>
                    </div>
                </form>
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
