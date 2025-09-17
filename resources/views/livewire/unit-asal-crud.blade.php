<div class="bg-white p-6 rounded-lg shadow">
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="mb-6 flex space-x-4">
        <input type="text" wire:model="nama" placeholder="Nama Unit Asal" class="border rounded p-2 flex-1">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            {{ $updateMode ? 'Update' : 'Tambah' }}
        </button>
        @if($updateMode)
            <button type="button" wire:click="resetInput" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                Batal
            </button>
        @endif
    </form>

    <table class="table-auto w-full border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Nama Unit Asal</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($units as $unit)
                <tr>
                    <td class="p-2 border">{{ $unit->id }}</td>
                    <td class="p-2 border">{{ $unit->nama }}</td>
                    <td class="p-2 border">
                        <button wire:click="edit({{ $unit->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="delete({{ $unit->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-2 text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
