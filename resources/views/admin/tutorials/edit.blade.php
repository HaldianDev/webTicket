<!-- resources/views/admin/tutorials/edit.blade.php -->
<x-app-layout>
    <div class="p-6 max-w-xl mx-auto bg-white rounded-xl shadow-lg mt-6 ring-1 ring-gray-200">
        <h2 class="text-3xl font-extrabold text-gray-900 mt-4 text-center">Edit Tutorial</h2>

        <form method="POST" action="{{ route('tutorials.update', $tutorial) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @include('admin.tutorials._form', ['tutorial' => $tutorial])
        </form>
    </div>
</x-app-layout>
