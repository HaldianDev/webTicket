<x-guest-layout>
    {{-- Kontainer utama responsive --}}
    <div class="flex flex-col md:flex-row w-full md:h-[80vh] my-6 md:my-12 rounded-xl shadow-xl overflow-hidden">

        {{-- Kiri: Form Login (Profesional) --}}
        <div class="w-full md:w-1/2 p-6 md:p-10 flex items-center justify-center bg-white">
            <div class="w-full max-w-md">
                <div class="flex justify-center mb-6">
                    <x-application-logo class="w-16 h-16" />
                </div>
                <h2 class="text-2xl font-semibold mb-2 text-gray-800 text-center">Selamat Datang Kembali</h2>
                <p class="text-gray-500 mb-6 text-center">Masukkan email dan password untuk melanjutkan</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <x-text-input id="email" class="block w-full" type="email" name="email" placeholder="Email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-text-input id="password" class="block w-full" type="password" name="password" placeholder="Password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mb-4 text-sm">
                        @if (Route::has('password.request'))
                            <a class="text-blue-500 hover:underline" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>
{{--
                    <x-primary-button class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-full flex justify-center mb-3">
                        Masuk
                    </x-primary-button> --}}
                    <button class="w-full bg-blue-600 text-white  mb-6 border border-gray-300 text-gray-700 rounded-full flex items-center justify-center space-x-2 shadow hover:bg-blue-50 transition px-4 py-2">
                        {{-- Gambar Google --}}
                      <img src="https://tulangbawangkab.go.id/img/logo/logo.png" alt="Google" class="w-4 h-5">
                        <span>Masuk</span>
                    </button>

                </form>
                <form method="GET" action="{{ route('google.redirect') }}" class="w-full">
                    <button type="submit" class="mt-5 w-full bg-blue-600 text-white  border border-gray-300 text-gray-700 rounded-full flex items-center justify-center space-x-2 shadow hover:bg-blue-50 transition px-4 py-2">
                        {{-- Gambar Google --}}
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                        <span>Google</span>
                    </button>
                </form>


            </div>
        </div>

        {{-- Kanan: Greeting (Menarik) --}}
        <div class="w-full md:w-1/2 bg-gradient-to-br from-blue-500 to-blue-700 text-white flex flex-col items-center justify-center p-8 relative overflow-hidden">
            {{-- Ilustrasi --}}
            <svg class="absolute bottom-0 right-0 w-40 opacity-20" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="256" cy="256" r="256" fill="white" />
            </svg>
            <img src="data:image/svg+xml,%3Csvg%20width%3D%22800px%22%20height%3D%22800px%22%20viewBox%3D%220%200%20512%20512%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20fill%3D%22%23ffffff%22%20stroke%3D%22%23ffffff%22%3E%3Cpath%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20d%3D%22M366.05%2C146a46.7%2C46.7%2C0%2C0%2C1-2.42-63.42%2C3.87%2C3.87%2C0%2C0%2C0-.22-5.26L319.28%2C33.14a3.89%2C3.89%2C0%2C0%2C0-5.5%2C0l-70.34%2C70.34a23.62%2C23.62%2C0%2C0%2C0-5.71%2C9.24h0a23.66%2C23.66%2C0%2C0%2C1-14.95%2C15h0a23.7%2C23.7%2C0%2C0%2C0-9.25%2C5.71L33.14%2C313.78a3.89%2C3.89%2C0%2C0%2C0%2C0%2C5.5l44.13%2C44.13a3.87%2C3.87%2C0%2C0%2C0%2C5.26.22%2C46.69%2C46.69%2C0%2C0%2C1%2C65.84%2C65.84%2C3.87%2C3.87%2C0%2C0%2C0%2C.22%2C5.26l44.13%2C44.13a3.89%2C3.89%2C0%2C0%2C0%2C5.5%2C0l180.4-180.39a23.7%2C23.7%2C0%2C0%2C0%2C5.71-9.25h0a23.66%2C23.66%2C0%2C0%2C1%2C14.95-15h0a23.62%2C23.62%2C0%2C0%2C0%2C9.24-5.71l70.34-70.34a3.89%2C3.89%2C0%2C0%2C0%2C0-5.5l-44.13-44.13a3.87%2C3.87%2C0%2C0%2C0-5.26-.22A46.7%2C46.7%2C0%2C0%2C1%2C366.05%2C146Z%22/%3E%3Cline%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20stroke-linecap%3D%22round%22%20x1%3D%22250.5%22%20y1%3D%22140.44%22%20x2%3D%22233.99%22%20y2%3D%22123.93%22/%3E%3Cline%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20stroke-linecap%3D%22round%22%20x1%3D%22294.52%22%20y1%3D%22184.46%22%20x2%3D%22283.51%22%20y2%3D%22173.46%22/%3E%3Cline%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20stroke-linecap%3D%22round%22%20x1%3D%22338.54%22%20y1%3D%22228.49%22%20x2%3D%22327.54%22%20y2%3D%22217.48%22/%3E%3Cline%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20stroke-linecap%3D%22round%22%20x1%3D%22388.07%22%20y1%3D%22278.01%22%20x2%3D%22371.56%22%20y2%3D%22261.5%22/%3E%3C/svg%3E" alt="Ticket Icon" class="w-48 mb-6" />
            {{-- <h2 class="text-3xl font-bold mb-4 text-center z-10">Open Ticket</h2> --}}
            {{-- <p class="text-lg text-center max-w-sm mb-6 z-10">
                Yuk daftar dan jadilah bagian dari komunitas kami. Prosesnya cepat dan gratis!

            </p>
            <a href="{{ route('register') }}" class="z-10">
                <button class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-100 transition">
                    Daftar Sekarang
                </button>
            </a> --}}
        </div>
    </div>
</x-guest-layout>
