<x-app-layout>
    <div class="flex">
        <main class="flex-1 p-6 bg-gray-50 min-h-screen">
            <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md border border-blue-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Riwayat Pengaduan</h2>

                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="mb-4 flex justify-end">
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
                                <th class="px-4 py-2 border">Kategori</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Aksi</th> <!-- Kolom baru -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengaduans as $index => $item)
                                <tr class="text-center">
                                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border">{{ $item->ticket_number }}</td>
                                        <td class="px-4 py-2 border">
                                            {{ \Illuminate\Support\Str::of($item->jenis_laporan)->replace('_', ' ')->title() }}
                                        </td>
                                        <td class="px-4 py-2 border">{{ $item->keterangan }}</td>
                                        <td class="px-4 py-2 border">
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $item->kategori_color }}">
                                                {{ ucfirst($item->kategori) }}
                                            </span>
                                        </td>
                                    <td class="px-4 py-2 border">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route('admin.pengaduan.show', $item->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-700 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm transition duration-150 ease-in-out">
                                                Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500">Belum ada pengaduan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
