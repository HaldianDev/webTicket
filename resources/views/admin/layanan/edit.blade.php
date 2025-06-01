<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Edit Layanan</h2>

        <form action="{{ route('admin.layanan.update', $layanan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.layanan._form', ['layanan' => $layanan])
        </form>
    </div>
</x-app-layout>
