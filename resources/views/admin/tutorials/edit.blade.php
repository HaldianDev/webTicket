<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Edit Tutorial</h2>

        <form method="POST" action="{{ route('admin.tutorials.update', $tutorial) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @include('admin.tutorials._form', ['tutorial' => $tutorial])
        </form>
    </div>
</x-app-layout>
