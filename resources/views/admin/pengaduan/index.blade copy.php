<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-extrabold mb-8 text-gray-800">Daftar Pengaduan</h2>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-md shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
            <table class="min-w-full table-auto divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jenis Laporan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pengaduans as $p)
                        <tr class="hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $p->id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $p->jenis_laporan ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $p->kategori_color }}">
                                    {{ $p->kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-center space-x-2">
                                <a href="{{ route('admin.pengaduan.show', $p->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-700 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm transition duration-150 ease-in-out">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">Belum ada pengaduan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $pengaduans->links() }}
        </div>
    </div>
</x-app-layout>
