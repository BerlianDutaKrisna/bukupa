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
        <input type="text" id="searchNorm" wire:model="searchNorm" wire:keydown.enter="searchPasien"
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
        <h2 class="text-xl font-bold mt-8 mb-2">Seluruh Pemeriksaan</h2>
        @include('components.table-pemeriksaan-all', [
            'pemeriksaanAll' => $pemeriksaanAll,
            'editingStatusId' => $editingStatusId,
        ])
    </div>
</div>

{{-- Tombol Upload Global --}}
@if ($foto_unit_asal)
    <div class="text-right my-3">
        <button wire:click="uploadFoto" wire:loading.attr="disabled"
            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm transition shadow-sm">
            <span wire:loading.remove>Upload</span>
            <svg wire:loading class="animate-spin w-4 h-4" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="3"
                    stroke-opacity="0.25" fill="none"></circle>
                <path d="M22 12a10 10 0 00-10-10" stroke="white" stroke-width="3" stroke-linecap="round"></path>
            </svg>
        </button>
    </div>
@endif

{{-- Modal Viewer Foto --}}
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
