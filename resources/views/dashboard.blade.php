<x-app-layout>
    <div x-data="{ sidebarOpen: true }" class="flex">
        <main class="flex-1 p-6 bg-gray-50 min-h-screen">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                @foreach ($layanans as $layanan)
                    <div class="bg-white p-5 rounded-[7px] shadow-lg hover:shadow-xl border border-blue-200 transition transform hover:-translate-y-1 flex gap-4">
                        <div class="flex-shrink-0 flex items-center justify-center">
                            <img src="{{ $layanan->gambar ?? 'https://tulangbawangkab.go.id/img/logo/logo.png' }}"
                                 alt="Icon {{ $layanan->nama_layanan }}" class="w-16 h-16 object-contain">
                        </div>
                        <div class="flex flex-col justify-between flex-grow">
                            <div>
                                <h3 class="text-lg font-semibold mb-2">{{ $layanan->nama_layanan }}</h3>
                                <p class="text-sm text-gray-700">{{ $layanan->deskripsi }}</p>
                            </div>
                            <div class="mt-4 flex justify-between">
                                <a href="{{ url('/pengaduan?nama_layanan=' . urlencode($layanan->nama_layanan)) }}"
                                class="text-sm text-blue-600 border border-blue-600 px-3 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                                    Create Ticket
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</x-app-layout>
