<x-guest-layout>
    <div class="flex flex-col md:flex-row w-full md:h-[85vh] my-6 md:my-12 rounded-xl shadow-lg overflow-hidden">

        {{-- Kiri: Form Register --}}
        <div class="w-full md:w-1/2 bg-white p-6 md:p-12 flex items-center justify-center">
            <div class="w-full max-w-md">
                <div class="flex justify-center mb-6">
                    <x-application-logo class="w-16 h-16" />
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Buat Akun Baru</h2>
                <p class="text-gray-600 text-center mb-6">Gabung dan mulai perjalananmu bersama kami!</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <x-text-input id="name" class="block w-full" type="text" name="name" placeholder="Nama Lengkap" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-text-input id="email" class="block w-full" type="email" name="email" placeholder="Email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-text-input id="password" class="block w-full" type="password" name="password" placeholder="Password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <x-primary-button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-semibold py-2 rounded-full transition" style="text-align: center">
                        Daftar
                    </x-primary-button>

                    <p class="text-center text-sm text-gray-600 mt-4">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
                    </p>
                </form>
            </div>
        </div>

        {{-- Kanan: Ilustrasi / Greeting --}}
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-r from-blue-500 to-blue-700 text-white flex-col items-center justify-center p-6 md:p-10">
            {{-- <img src="https://cdn-icons-png.flaticon.com/512/6815/6815043.png" alt="Welcome" class="w-48 mb-6" /> --}}
            <img src="data:image/svg+xml,%3Csvg%20width%3D%22800px%22%20height%3D%22800px%22%20viewBox%3D%220%200%20512%20512%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20fill%3D%22%23ffffff%22%20stroke%3D%22%23ffffff%22%3E%3Cpath%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20d%3D%22M366.05%2C146a46.7%2C46.7%2C0%2C0%2C1-2.42-63.42%2C3.87%2C3.87%2C0%2C0%2C0-.22-5.26L319.28%2C33.14a3.89%2C3.89%2C0%2C0%2C0-5.5%2C0l-70.34%2C70.34a23.62%2C23.62%2C0%2C0%2C0-5.71%2C9.24h0a23.66%2C23.66%2C0%2C0%2C1-14.95%2C15h0a23.7%2C23.7%2C0%2C0%2C0-9.25%2C5.71L33.14%2C313.78a3.89%2C3.89%2C0%2C0%2C0%2C0%2C5.5l44.13%2C44.13a3.87%2C3.87%2C0%2C0%2C0%2C5.26.22%2C46.69%2C46.69%2C0%2C0%2C1%2C65.84%2C65.84%2C3.87%2C3.87%2C0%2C0%2C0%2C.22%2C5.26l44.13%2C44.13a3.89%2C3.89%2C0%2C0%2C0%2C5.5%2C0l180.4-180.39a23.7%2C23.7%2C0%2C0%2C0%2C5.71-9.25h0a23.66%2C23.66%2C0%2C0%2C1%2C14.95-15h0a23.62%2C23.62%2C0%2C0%2C0%2C9.24-5.71l70.34-70.34a3.89%2C3.89%2C0%2C0%2C0%2C0-5.5l-44.13-44.13a3.87%2C3.87%2C0%2C0%2C0-5.26-.22A46.7%2C46.7%2C0%2C0%2C1%2C366.05%2C146Z%22/%3E%3Cline%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20stroke-linecap%3D%22round%22%20x1%3D%22250.5%22%20y1%3D%22140.44%22%20x2%3D%22233.99%22%20y2%3D%22123.93%22/%3E%3Cline%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20stroke-linecap%3D%22round%22%20x1%3D%22294.52%22%20y1%3D%22184.46%22%20x2%3D%22283.51%22%20y2%3D%22173.46%22/%3E%3Cline%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20stroke-linecap%3D%22round%22%20x1%3D%22338.54%22%20y1%3D%22228.49%22%20x2%3D%22327.54%22%20y2%3D%22217.48%22/%3E%3Cline%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-miterlimit%3D%2210%22%20stroke-width%3D%2232%22%20stroke-linecap%3D%22round%22%20x1%3D%22388.07%22%20y1%3D%22278.01%22%20x2%3D%22371.56%22%20y2%3D%22261.5%22/%3E%3C/svg%3E" alt="Ticket Icon" class="w-48 mb-6" />

            <h2 class="text-3xl font-bold mb-2 text-center">Selamat Datang!</h2>
            <p class="text-center max-w-sm">Sudah siap untuk menjelajah fitur menarik? Yuk mulai dari sini!</p>
        </div>
    </div>
</x-guest-layout>
