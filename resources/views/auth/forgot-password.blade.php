<x-guest-layout>
  <div class="flex flex-col md:flex-row w-full md:h-[80vh] my-6 md:my-12 rounded-xl shadow-xl overflow-hidden bg-white">

{{-- Left side image/illustration --}}
<div class="hidden md:block md:w-1/2 bg-gradient-to-tr from-blue-400 via-blue-500 to-blue-600 flex items-center justify-center">
<div class="flex items-center justify-center h-full w-full">
    <img src="https://tulangbawangkab.go.id/img/logo/logo.png" alt="Logo Tulang Bawang" width="200px"  />
</div>

</div>


    {{-- Right side form --}}
    <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
      <h2 class="text-3xl font-bold text-gray-800 mb-6">Reset Password</h2>
      <p class="mb-6 text-gray-600">
        Lupa kata sandi? Jangan khawatir. Masukkan alamat email Anda di bawah ini, dan kami akan mengirimkan link untuk setting ulang kata sandi Anda.
      </p>

      <!-- Session Status -->
      <x-auth-session-status class="mb-4" :status="session('status')" />

      <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
          <x-input-label for="email" :value="__('Email')" class="block text-gray-700 font-medium mb-2" />
          <x-text-input
              id="email"
              class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition"
              type="email"
              name="email"
              :value="old('email')"
              required
              autofocus
              autocomplete="email"
              placeholder="your.email@example.com"
          />
          <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex justify-end">
          <x-primary-button class="bg-blue-500 hover:bg-blue-600 w-full sm:w-auto px-8 py-3 rounded-full text-white font-semibold transition shadow-lg hover:shadow-xl">
            {{ __('Kirim') }}
          </x-primary-button>
        </div>
      </form>
    </div>
  </div>
</x-guest-layout>
