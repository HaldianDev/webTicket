<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Tambah Layanan</h2>

        <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.layanan._form', ['layanan' => new \App\Models\Layanan()])
        </form>
    </div>
</x-app-layout>

