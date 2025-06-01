<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Tambah Tutorial</h2>

        <form method="POST" action="{{ route('admin.tutorials.store') }}" class="space-y-6">
            @csrf
            @include('admin.tutorials._form', ['tutorial' => new \App\Models\Tutorial()])
        </form>
    </div>
</x-app-layout>
