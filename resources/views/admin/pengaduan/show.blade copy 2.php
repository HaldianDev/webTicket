<x-app-layout>
    <div class="container mx-auto px-6 py-8 max-w-5xl">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">
            Detail Pengaduan #{{ $pengaduan->ticket_number ?? $pengaduan->id }}
        </h2>

        {{-- SweetAlert2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- AlpineJS CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: "{{ session('success') }}",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                });
            </script>
        @endif

        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-6">

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
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $pengaduan->kategori_class ?? 'bg-gray-200 text-gray-700' }}">
                            {{ $pengaduan->kategori_label ?? ($pengaduan->kategori ?? '-') }}
                        </span>
                    </div>
                </div>


                <!-- Dropdown Status Custom -->
                <div class="relative font-semibold" x-data="{ open: false, status: '{{ $pengaduan->status }}' }" @click.away="open = false">
                       <h3 class="text-sm font-semibold text-gray-600 mb-1">Status</h3>
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

                <div class="lg:col-span-2 mt-4">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">File Lampiran</h3>
                    @if ($pengaduan->file_path)
                        <div class="border rounded-md p-3 bg-gray-50 text-center">
                            <a href="{{ asset('storage/' . $pengaduan->file_path) }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('storage/' . $pengaduan->file_path) }}" class="max-h-80 mx-auto object-contain" alt="Lampiran Pengaduan"/>
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

            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('admin.pengaduan.index') }}"
                   class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                    Kembali
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
