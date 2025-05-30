<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tutorial Video</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($tutorials as $tutorial)
                @php
                    $videoId = null;
                    if (preg_match('/v=([^&]+)/', $tutorial->youtube_url, $matches)) {
                        $videoId = $matches[1];
                    }
                @endphp

                <div class="bg-white shadow-md hover:shadow-xl rounded-2xl overflow-hidden transform transition duration-300 hover:-translate-y-1 hover:ring hover:ring-blue-100">
                    @if ($videoId)
                        <a href="{{ $tutorial->youtube_url }}" target="_blank">
                            <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg" alt="{{ $tutorial->title }}" class="w-full h-32 object-cover hover:scale-105 transition-transform duration-300">
                        </a>
                    @endif
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-gray-900 truncate" title="{{ $tutorial->title }}">
                            {{ $tutorial->title }}
                        </h3>
                        <p class="text-xs text-gray-600 mt-1">
                            {{ Str::limit($tutorial->description, 60) }}
                        </p>
                    <a href="{{ $tutorial->youtube_url }}" target="_blank"
                         class="inline-block mt-2 px-4 py-2 text-xs font-semibold text-white bg-green-600 rounded-md hover:bg-green-700 transition shadow-sm">
                        🎥 Tonton Video
                    </a>

                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full text-center">Belum ada tutorial yang tersedia.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
