<x-layouts.auth title="Register | Buat Akun Baru" subtitle="Isi data di bawah untuk mendaftar">
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <input type="text" name="nama" value="{{ old('nama') }}"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                placeholder="Nama Lengkap" required>
            @error('nama') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <input type="text" name="username" value="{{ old('username') }}"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                placeholder="Username" required>
            @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <select name="id_unit_asal"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                <option value="">Pilih Unit Asal</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('id_unit_asal') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->nama }}
                    </option>
                @endforeach
            </select>
            @error('id_unit_asal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <input type="password" name="password"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                placeholder="Password" required>
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <input type="password" name="password_confirmation"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                placeholder="Konfirmasi Password" required>
        </div>

        <button type="submit"
            class="w-full flex items-center justify-center gap-2 
            border border-sky-500 bg-sky-500 text-white font-medium 
            py-3 rounded-lg shadow-md 
            hover:bg-sky-600 hover:shadow-lg transition">
            <span>Register</span>
        </button>

        <p class="text-center text-sm mt-4">
            Sudah punya akun? <a href="{{ route('login.show') }}" class="text-indigo-600 hover:underline">Login</a>
        </p>
    </form>
</x-layouts.auth>
