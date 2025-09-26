<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">CRUD Pemeriksaan</h1>

    <!-- Search & per page -->
    <div class="flex items-center gap-2 mb-4">
        <input type="text" wire:model.debounce.500ms="search"
            placeholder="Cari pasien..."
            class="border px-3 py-2 rounded w-1/3" />

        <select wire:model="perPage" class="border px-2 py-2 rounded">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>

    <!-- Flash message -->
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Pasien</th>
                    <th class="p-2 border">User</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Diagnosa</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemeriksaan as $periksa)
                    <tr class="hover:bg-gray-100">
                        <td class="p-2 border">{{ $periksa->id }}</td>
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($periksa->tanggal_pemeriksaan)->format('d-m-Y H:i') }}</td>
                        <td class="p-2 border">{{ $periksa->pasien->nama ?? '-' }}</td>
                        <td class="p-2 border">{{ $periksa->user->nama ?? '-' }}</td>
                        <td class="p-2 border">{{ $periksa->status ?? '-' }}</td>
                        <td class="p-2 border">{{ $periksa->diagnosa_klinik ?? '-' }}</td>
                        <td class="p-2 border space-x-1">
                            <button wire:click="edit({{ $periksa->id }})"
                                class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Edit</button>
                            <button wire:click="delete({{ $periksa->id }})"
                                class="bg-red-500 text-white px-2 py-1 rounded text-sm">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4 text-gray-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $pemeriksaan->links() }}
    </div>

    <!-- Modal Viewer Foto -->
    @if ($viewerOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
            <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl w-full">
                @if ($currentFoto)
                    <img src="{{ Storage::url($currentFoto) }}" alt="Foto Unit Asal"
                        class="max-h-[70vh] mx-auto rounded">
                @else
                    <p class="text-center text-gray-500">Belum ada foto diupload.</p>
                @endif
                <div class="mt-4 text-center">
                    <button wire:click="closeViewer"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tutup</button>
                </div>
            </div>
        </div>
    @endif
</div>
