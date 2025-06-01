<x-app-layout>
    <div class="container mx-auto p-6 max-w-4xl">
        <h2 class="text-3xl font-extrabold mb-6 text-gray-800">Detail Pengaduan #{{ $pengaduan->id }}</h2>

        <div class="bg-white shadow rounded-lg p-6 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data lain... -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Jenis Laporan</h3>
                    <p class="text-gray-900">{{ $pengaduan->jenis_laporan ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Kategori</h3>
                    <p class="text-gray-900">{{ $pengaduan->kategori ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Keterangan</h3>
                    <p class="text-gray-900 whitespace-pre-line">{{ $pengaduan->keterangan ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Phone</h3>
                    <p class="text-gray-900">{{ $pengaduan->phone ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Lokasi</h3>
                    <p class="text-gray-900">{{ $pengaduan->lokasi ?? '-' }}</p>
                </div>

                <!-- Dropdown Status Custom -->
                <div class="relative" x-data="{ open: false, status: '{{ $pengaduan->status }}' }" @click.away="open = false">
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Status</h3>
                    <form id="statusForm" action="{{ route('admin.pengaduan.updateStatus', $pengaduan) }}" method="POST" x-ref="statusForm">
                        @csrf
                        @method('PUT')
                        <button
                            type="button"
                            @click="open = !open"
                            class="w-full text-left border border-indigo-600 rounded-lg px-4 py-2 bg-indigo-50 shadow-sm
                                   flex justify-between items-center font-semibold text-indigo-700
                                   hover:bg-indigo-100 transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <span x-text="{
                                pending: 'Pending',
                                diproses: 'Diproses',
                                selesai: 'Selesai',
                                batal: 'Batal'
                            }[status]"></span>
                            <svg class="w-5 h-5 ml-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown panel -->
                        <ul
                            x-show="open"
                            x-transition
                            class="absolute z-30 mt-1 w-full bg-white border border-indigo-600 rounded-lg shadow-lg
                                   max-h-60 overflow-auto"
                            style="display: none;"
                        >
                            @php
                                $statuses = [
                                    'pending' => 'Pending',
                                    'diproses' => 'Diproses',
                                    'selesai' => 'Selesai',
                                    'batal' => 'Batal',
                                ];
                            @endphp
                            @foreach ($statuses as $key => $label)
                                <li
                                    @click="
                                        status = '{{ $key }}';
                                        open = false;
                                        $refs.statusInput.value = status;
                                        $refs.statusForm.submit();
                                    "
                                    class="cursor-pointer px-4 py-2 hover:bg-indigo-600 hover:text-white transition
                                           "
                                    :class="status === '{{ $key }}' ? 'bg-indigo-600 text-white font-bold' : ''"
                                >
                                    {{ $label }}
                                </li>
                            @endforeach
                        </ul>

                        <input type="hidden" name="status" x-ref="statusInput" :value="status" />
                    </form>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">File Lampiran</h3>
                    @if ($pengaduan->file_path)
                        <a href="{{ asset($pengaduan->file_path) }}" target="_blank" class="inline-block border rounded shadow hover:shadow-lg transition p-2">
                            <img src="{{ asset($pengaduan->file_path) }}" alt="Lampiran Pengaduan #{{ $pengaduan->id }}" class="max-h-80 object-contain" />
                        </a>
                        <p class="mt-2 text-sm text-gray-500">Klik gambar untuk melihat atau <a href="{{ asset($pengaduan->file_path) }}" download class="text-indigo-600 underline">download file</a>.</p>
                    @else
                        <p class="text-gray-400 italic">Tidak ada file lampiran.</p>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.pengaduan.index') }}"
                   class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md
                          hover:bg-indigo-700 hover:shadow-lg transition duration-300 ease-in-out
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
