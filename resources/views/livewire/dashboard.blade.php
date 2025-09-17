<div class="p-4 space-y-6">
    <h1 class="text-2xl font-bold">{{ $appName }}</h1>

    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Input Search --}}
    <div class="flex gap-2">
        <input type="text" id="searchNorm"
            wire:model="searchNorm"
            wire:keydown.enter="searchPasien"
            placeholder="Cari No RM pasien..."
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400 flex-1" />
        <button wire:click="searchPasien"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cari
        </button>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading class="text-blue-500 mt-2">
        Sedang mencari pasien...
    </div>

    {{-- Hasil Pencarian --}}
    <div class="mt-4">
        @if ($pasiens->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="p-2 border">No RM</th>
                            <th class="p-2 border">Nama</th>
                            <th class="p-1 border w-24 whitespace-nowrap">Jenis Kelamin</th>
                            <th class="p-2 border">Alamat</th>
                            <th class="p-2 border">Tanggal Pemeriksaan</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pasiens as $pasien)
                            <tr class="hover:bg-gray-100">
                                <td class="p-2 border">{{ $pasien->norm }}</td>
                                <td class="p-2 border">{{ $pasien->nama ?? '-' }}</td>
                                <td class="p-2 border text-center">{{ $pasien->jenkel ?? '-' }}</td>
                                <td class="p-2 border">{{ $pasien->alamat ?? '-' }}</td>
                                <td class="p-2 border">
                                    <input type="date" wire:model="tanggalPemeriksaan.{{ $pasien->id }}"
                                        class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm 
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                        text-sm text-gray-700" />
                                </td>
                                <td class="p-2 border">
                                    <button wire:click="tambahPemeriksaan({{ $pasien->id }})"
                                        class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                                        Tambah Pemeriksaan
                                    </button>
                                </td>
                            </tr>
                            @if (isset($expanded[$pasien->id]))
                                <tr>
                                    <td colspan="6" class="p-2 border bg-gray-50">
                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div><strong>NIK:</strong> {{ $pasien->nik ?? '-' }}</div>
                                            <div><strong>Alamat:</strong> {{ $pasien->alamat ?? '-' }}</div>
                                            <div><strong>Kota:</strong> {{ $pasien->kota ?? '-' }}</div>
                                            <div><strong>Jenis Kelamin:</strong>
                                                {{ $pasien->jenkel == 'L' ? 'Laki-laki' : ($pasien->jenkel == 'P' ? 'Perempuan' : '-') }}
                                            </div>
                                            <div><strong>Tanggal Lahir:</strong> {{ $pasien->tgl_lhr ?? '-' }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($searchNorm)
            <div class="text-red-500">
                Pasien dengan No RM "{{ $searchNorm }}" tidak ditemukan.
            </div>
        @endif
    </div>

    {{-- Pemeriksaan Hari Ini --}}
    <div>
        <h2 class="text-xl font-bold mb-2">
            Pemeriksaan Hari Ini ({{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d-m-Y') }})
        </h2>
        @include('components.table-pemeriksaan', [
            'pemeriksaan' => $pemeriksaan,
            'editingStatusId' => $editingStatusId,
        ])
    </div>

    {{-- Pemeriksaan Semua --}}
    <div>
        <h2 class="text-xl font-bold mt-8 mb-2">
            Seluruh Pemeriksaan
        </h2>
        @include('components.table-pemeriksaan-all', [
            'pemeriksaanAll' => $pemeriksaanAll,
            'editingStatusId' => $editingStatusId,
        ])
    </div>
</div>

{{-- Script Fokus Cursor --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchNorm");
        if (searchInput) {
            searchInput.focus();
        }
    });

    // Event dari Livewire (misalnya setelah tambah pemeriksaan)
    window.addEventListener('focus-search', () => {
        const searchInput = document.getElementById('searchNorm');
        if (searchInput) {
            searchInput.focus();
        }
    });
</script>
