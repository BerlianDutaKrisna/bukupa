<div class="p-4 space-y-6">
    <h1 class="text-2xl font-bold">{{ $appName }}</h1>

    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex gap-2">
        <input type="text" id="searchNorm" wire:model="searchNorm" wire:keydown.enter="searchPasien"
            placeholder="Cari No RM pasien..." autocomplete="off"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400 flex-1" />

        <button wire:click="searchPasien" wire:loading.attr="disabled"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cari
        </button>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading class="text-blue-500 mt-2">
        Sedang mencari pasien...
    </div>

    {{-- Error Message --}}
    @if (session()->has('search_error'))
        <div class="mb-2 p-2 bg-red-100 text-red-700 rounded">
            {{ session('search_error') }}
        </div>
    @endif

    {{-- Hasil Pencarian --}}
    <div class="mt-4">
        @if ($pasiens->isNotEmpty())
            <ul class="space-y-2">
                @foreach ($pasiens as $pasien)
                    <li class="border p-2 rounded flex items-center gap-4">
                        {{-- Kolom 1: Identitas Pasien --}}
                        <div class="flex-1">
                            <strong>{{ $pasien->nama }}</strong> ({{ $pasien->jenkel }}) <br>
                            RM: {{ $pasien->norm }} |
                            Tgl Lahir:
                            {{ $pasien->tgl_lhr ? \Carbon\Carbon::parse($pasien->tgl_lhr)->format('d-m-Y') : '-' }} <br>
                            Alamat: {{ $pasien->alamat ?? '-' }}
                        </div>

                        {{-- Kolom 2: Tanggal Pemeriksaan --}}
                        <div>
                            <input type="date" wire:model="tanggalPemeriksaan.{{ $pasien->id }}"
                                class="border p-1 rounded text-sm" />
                        </div>

                        {{-- Kolom 3: Tombol Tambah Pemeriksaan --}}
                        <div>
                            <button wire:click="tambahPemeriksaan({{ $pasien->id }})"
                                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">
                                Tambah Pemeriksaan
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Tidak ada pasien ditemukan.</p>
        @endif
    </div>

    <div>
        <h2 class="text-xl font-bold mb-2">
            Pemeriksaan Hari Ini ({{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d-m-Y') }})
        </h2>
        @include('components.table-pemeriksaan', [
            'pemeriksaan' => $pemeriksaan,
            'editingStatusId' => $editingStatusId,
        ])
    </div>

    <div>
        <h2 class="text-xl font-bold mt-8 mb-2">Seluruh Pemeriksaan</h2>
        @include('components.table-pemeriksaan-all', [
            'pemeriksaanAll' => $pemeriksaanAll,
            'editingStatusId' => $editingStatusId,
        ])
    </div>
</div>

@if ($foto_unit_asal)
    <div class="text-right my-3">
        <button wire:click="uploadFoto" wire:loading.attr="disabled"
            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm transition shadow-sm">
            <span wire:loading.remove>Upload</span>
            <svg wire:loading class="animate-spin w-4 h-4" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" stroke-opacity="0.25"
                    fill="none"></circle>
                <path d="M22 12a10 10 0 00-10-10" stroke="white" stroke-width="3" stroke-linecap="round"></path>
            </svg>
        </button>
    </div>
@endif

@if ($viewerOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl w-full" wire:key="viewer-{{ $pemeriksaanId }}">
            @if ($currentFoto)
                <img src="{{ Storage::url($currentFoto) }}" alt="Foto Unit Asal" class="max-h-[70vh] mx-auto rounded">
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
