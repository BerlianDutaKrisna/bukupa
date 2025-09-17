<div class="p-4 space-y-6">

    <h2 class="text-xl font-bold mb-4">Manajemen Pasien</h2>

    <!-- Flash message -->
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Collapse Form -->
    @if($showForm)
        <div class="border p-4 rounded bg-gray-50 transition duration-300">
            <h3 class="text-lg font-semibold mb-2">{{ $updateMode ? 'Edit Pasien' : 'Tambah Pasien' }}</h3>

            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="space-y-2">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <input type="text" wire:model="norm" placeholder="No RM" class="border p-2 w-full" required>
                    <input type="text" wire:model="nik" placeholder="NIK" class="border p-2 w-full">
                    <input type="text" wire:model="nama" placeholder="Nama" class="border p-2 w-full">
                    <input type="text" wire:model="alamat" placeholder="Alamat" class="border p-2 w-full">
                    <input type="text" wire:model="kota" placeholder="Kota" class="border p-2 w-full">
                    <select wire:model="jenkel" class="border p-2 w-full">
                        <option value="">-- Jenis Kelamin --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <input type="date" wire:model="tgl_lhr" class="border p-2 w-full">
                </div>
                <div class="space-x-2 mt-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        {{ $updateMode ? 'Update' : 'Simpan' }}
                    </button>
                    <button type="button" wire:click="resetInputFields" class="bg-gray-500 text-white px-4 py-2 rounded">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Table Pasien -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">No RM</th>
                    <th class="border px-4 py-2">NIK</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Alamat</th>
                    <th class="border px-4 py-2">Kota</th>
                    <th class="border px-4 py-2">Jenis Kelamin</th>
                    <th class="border px-4 py-2">Tanggal Lahir</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasiens as $pasien)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $pasien->norm }}</td>
                        <td class="border px-4 py-2">{{ $pasien->nik ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $pasien->nama ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $pasien->alamat ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $pasien->kota ?? '-' }}</td>
                        <td class="border px-4 py-2">
                            {{ $pasien->jenkel == 'L' ? 'Laki-laki' : ($pasien->jenkel == 'P' ? 'Perempuan' : '-') }}
                        </td>
                        <td class="border px-4 py-2">{{ $pasien->tgl_lhr ?? '-' }}</td>
                        <td class="border px-4 py-2 space-x-1">
                            <button wire:click="edit({{ $pasien->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                            <button wire:click="delete({{ $pasien->id }})" class="bg-red-500 text-white px-2 py-1 rounded" onclick="confirm('Yakin ingin hapus?') || event.stopImmediatePropagation()">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="border px-4 py-2 text-center">Tidak ada data pasien.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
