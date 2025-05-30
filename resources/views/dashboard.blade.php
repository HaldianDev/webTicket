<x-app-layout>
    <div x-data="{ sidebarOpen: true }" class="flex">
        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-50 min-h-screen">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">

                <!-- Card Items -->
                @for ($i = 0; $i < 12; $i++)
                    <div class="bg-white p-5 rounded-[7px] shadow-lg hover:shadow-xl border border-blue-200 transition transform hover:-translate-y-1 flex gap-4">
                        <!-- Gambar kiri -->
                        <div class="flex-shrink-0 flex items-center justify-center">
                            <img src="https://tulangbawangkab.go.id/img/logo/logo.png" alt="Icon" class="w-16 h-16 object-contain">
                        </div>

                        <!-- Konten -->
                        <div class="flex flex-col justify-between flex-grow">
                            <div>
                                <h3 class="text-lg font-semibold mb-2">BaaS</h3>
                                <p class="text-sm text-gray-700">
                                    Backup as a Service (BaaS) menyediakan pencadangan dan replikasi data berbasis VM Ware.
                                </p>
                            </div>
                            <div class="mt-4 flex justify-between">
                                <a href="/pengaduan" class="text-sm text-blue-600 border border-blue-600 px-3 py-1 rounded hover:bg-blue-600 hover:text-white transition">Create Ticket</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </main>


    </div>
</x-app-layout>
