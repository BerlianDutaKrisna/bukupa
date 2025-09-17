<x-layouts.auth title="Login | Buku PA Digital" subtitle="Masukkan data akun Anda untuk login">
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Username -->
        <div class="space-y-1">
            <div
                class="flex items-center border border-white/30 rounded-lg px-3 py-2 
                bg-white/10 backdrop-blur-sm transition duration-300
                hover:border-sky-400 hover:shadow-lg 
                focus-within:border-sky-500 focus-within:shadow-sky-500/50">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-black mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>

                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full bg-transparent text-black placeholder-gray-700 focus:outline-none"
                    placeholder="Username" required>
            </div>
            @error('username')
                <p class="text-red-400 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <div
                class="flex items-center border border-white/30 rounded-lg px-3 py-2 
                bg-white/10 backdrop-blur-sm transition duration-300
                hover:border-sky-400 hover:shadow-lg 
                focus-within:border-sky-500 focus-within:shadow-sky-500/50">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-black mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>

                <input type="password" name="password" id="password"
                    class="w-full bg-transparent text-black placeholder-gray-700 focus:outline-none"
                    placeholder="Password" required>

                <!-- Toggle button -->
                <button type="button" onclick="togglePassword()"
                    class="ml-2 text-gray-700 hover:text-black focus:outline-none">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-400 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Button -->
        <button type="submit"
            class="w-full flex items-center justify-center gap-2 
            border border-sky-500 bg-sky-500 text-white font-medium 
            py-3 rounded-lg shadow-md 
            hover:bg-sky-600 hover:shadow-lg transition">
            <span>Login</span>
        </button>

        <!-- Register link -->
        <p class="text-center text-sm mt-4">
            Belum punya akun?
            <a href="{{ route('register.show') }}" class="text-sky-600 hover:underline">
                Daftar
            </a>
        </p>
    </form>

    <!-- JS Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                // Ubah ikon ke "mata tertutup"
                eyeIcon.innerHTML =
                    `
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 0 0 2.25 12c0 .999.146 1.956.417 2.86M21.75 12c0 .999-.146 1.956-.417 2.86M6.456 6.456a9.963 9.963 0 0 1 5.544-1.706c4.25 0 7.901 2.52 9.326 6a10.478 10.478 0 0 1-1.745 2.861M6.456 6.456L3 3m15 15-3.456-3.456" />`;
            } else {
                passwordInput.type = "password";
                // Ubah ikon ke "mata terbuka"
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                    <circle cx="12" cy="12" r="3" />`;
            }
        }
    </script>
</x-layouts.auth>
