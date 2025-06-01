<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-8">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <p class="text-sm text-gray-500 uppercase tracking-wide">Total Tiket</p>
                <h3 class="text-3xl font-extrabold text-indigo-600">{{ $total }}</h3>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <p class="text-sm text-gray-500 uppercase tracking-wide">Tiket Aktif</p>
                <h3 class="text-3xl font-extrabold text-yellow-500">{{ $aktif }}</h3>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <p class="text-sm text-gray-500 uppercase tracking-wide">Selesai</p>
                <h3 class="text-3xl font-extrabold text-green-600">{{ $selesai }}</h3>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <p class="text-sm text-gray-500 uppercase tracking-wide">Rata-rata Waktu</p>
                <h3 class="text-3xl font-extrabold text-gray-700">{{ number_format($rataRataJam, 1) }} Jam</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tiket Terbaru -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4 border-b pb-2 border-indigo-500">Tiket Terbaru</h2>
                <ul id="listTiket" class="divide-y divide-gray-200 max-h-[400px] overflow-y-auto">
                    @foreach ($terbaru as $tiket)
                        <li class="py-3 flex justify-between items-center hover:bg-indigo-50 rounded px-2 transition cursor-pointer"
                            data-id="{{ $tiket->id }}">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $tiket->jenis_laporan }}</p>
                                <span class="text-xs text-gray-400">{{ $tiket->ticket_number }}</span>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                {{ $tiket->status === 'open' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $tiket->status === 'onprogress' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $tiket->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $tiket->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($tiket->status) }}
                            </span>
                        </li>
                    @endforeach
                </ul>

                <!-- Container komentar -->
                <div id="komentarContainer" class="mt-10 border-t pt-6 hidden">
                    <h3 class="text-xl font-semibold mb-4">Komentar</h3>
                    <div id="listKomentar" class="space-y-4"></div>

                    <form id="formKomentar" method="POST" class="mt-4 hidden">
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
            </div>

            <!-- Distribusi Status Chart -->
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                <h2 class="text-2xl font-semibold mb-4 border-b pb-2 border-indigo-500 w-full text-center">Distribusi Status</h2>
                <canvas id="statusChart" class="w-full max-w-md"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('statusChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Open', 'On Progress', 'Resolved', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $statusDistribusi['open'] }},
                        {{ $statusDistribusi['onprogress'] }},
                        {{ $statusDistribusi['resolved'] }},
                        {{ $statusDistribusi['rejected'] }}
                    ],
                    backgroundColor: [
                        '#3b82f6',   // blue
                        '#facc15',   // yellow
                        '#10b981',   // green
                        '#ef4444'    // red
                    ],
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const listTiket = document.getElementById('listTiket');
            const komentarContainer = document.getElementById('komentarContainer');
            const listKomentar = document.getElementById('listKomentar');
            const formKomentar = document.getElementById('formKomentar');
            const textarea = formKomentar.querySelector('textarea');
            let currentTiketId = null;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            listTiket.querySelectorAll('li').forEach(li => {
                li.addEventListener('click', () => {
                    const id = li.getAttribute('data-id');
                    currentTiketId = id;
                    fetchComments(id);
                    komentarContainer.classList.remove('hidden');
                    formKomentar.classList.remove('hidden');
                });
            });

            function fetchComments(id) {
                fetch(`/pengaduan/${id}/comments`)
                    .then(res => res.json())
                    .then(data => {
                        listKomentar.innerHTML = '';
                        if (data.length === 0) {
                            listKomentar.innerHTML = '<p class="text-gray-500">Belum ada komentar.</p>';
                        } else {
                            data.forEach(c => {
                                const div = document.createElement('div');
                                div.className = `p-4 rounded-md ${c.is_author ? 'bg-blue-50' : 'bg-gray-100'}`;
                                div.innerHTML = `
                                    <p class="text-sm text-gray-600">
                                        <strong>${c.user}</strong> <span class="text-xs text-gray-500">(${c.time})</span>
                                    </p>
                                    <p class="text-gray-800 mt-1">${c.message}</p>
                                `;
                                listKomentar.appendChild(div);
                            });
                        }
                    })
                    .catch(e => {
                        listKomentar.innerHTML = '<p class="text-red-500">Gagal memuat komentar.</p>';
                    });
            }

            formKomentar.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = textarea.value.trim();
                if (!message) return;

                fetch(`/pengaduan/${currentTiketId}/comment`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message }),
                }).then(res => {
                    if (res.ok) {
                        textarea.value = '';
                        fetchComments(currentTiketId);
                    } else {
                        alert('Gagal mengirim komentar');
                    }
                }).catch(() => alert('Gagal mengirim komentar'));
            });
        });
    </script>
</x-app-layout>
