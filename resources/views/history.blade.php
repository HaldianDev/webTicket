<x-app-layout>
    <div class="flex">
        <main class="flex-1 p-6 bg-gray-50 min-h-screen">
            <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md border border-blue-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Riwayat Pengaduan</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Jenis Laporan</th>
                                <th class="px-4 py-2 border">Keterangan</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengaduans as $index => $item)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ ucfirst($item->jenis_laporan) }}</td>
                                    <td class="px-4 py-2 border">{{ $item->keterangan }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ $item->status ?? 'Pending' }}
                                    </td>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($item->file_path)
                                            <a href="{{ asset('storage/' . $item->file_path) }}" class="text-blue-600 underline" target="_blank">Download</a>
                                        @else
                                            <span class="text-gray-500">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada pengaduan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
