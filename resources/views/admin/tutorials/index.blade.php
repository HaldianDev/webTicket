<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Tutorial</h2>
            <a href="{{ route('tutorials.create') }}"
               class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Tutorial
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 rounded-xl">
                <thead class="bg-gray-100 rounded-t-xl">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide rounded-tl-xl">Thumbnail</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Judul</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Deskripsi</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($tutorials as $tutorial)
                        @php
                            $videoId = null;
                            if (preg_match('/v=([^&]+)/', $tutorial->youtube_url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        <tr class="hover:bg-indigo-50 transition-colors duration-300">
                            <td class="px-6 py-3 whitespace-nowrap">
                                @if($videoId)
                                    <a href="{{ $tutorial->youtube_url }}" target="_blank" class="inline-block rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" alt="Thumbnail {{ e($tutorial->title) }}" class="w-40 h-24 object-cover hover:scale-105 transition-transform duration-300" />
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">No thumbnail</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 max-w-xs truncate font-semibold text-gray-900" title="{{ $tutorial->title }}">
                                {{ $tutorial->title }}
                            </td>
                            <td class="px-6 py-3 max-w-lg text-gray-700 text-sm truncate" title="{{ $tutorial->description }}">
                                {{ Str::limit($tutorial->description, 130) }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-center space-x-3">
                                <a href="{{ route('tutorials.edit', $tutorial) }}"
                                   class="inline-block px-5 py-2 rounded-lg bg-yellow-500 text-white font-semibold shadow-md transition duration-300 transform hover:shadow-lg hover:-translate-y-0.5">
                                    Edit
                                </a>

                                <form action="{{ route('tutorials.destroy', $tutorial) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus tutorial ini?');">
                                    @csrf

                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-block px-5 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 hover:shadow-md transition duration-300 transform hover:-translate-y-0.5">
                                              Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 px-6 py-8">
                                Belum ada tutorial yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
