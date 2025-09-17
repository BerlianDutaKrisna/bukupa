<div class="p-6">
    <h1 class="text-xl font-bold mb-4">CRUD Transaksi</h1>

    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tambah -->
    <div class="mb-4">
        <input type="text" wire:model="idtransaksi" placeholder="ID Transaksi"
            class="border p-2 rounded w-full mb-2">
        <input type="date" wire:model="tanggal" class="border p-2 rounded w-full mb-2">
        <input type="text" wire:model="nama" placeholder="Nama Pasien"
            class="border p-2 rounded w-full mb-2">
        <input type="text" wire:model="norm" placeholder="No RM"
            class="border p-2 rounded w-full mb-2">

        @if ($updateMode)
            <button wire:click="update" class="bg-yellow-500 px-4 py-2 rounded text-white">Update</button>
        @else
            <button wire:click="store" class="bg-blue-500 px-4 py-2 rounded text-white">Tambah</button>
        @endif
    </div>

    <!-- Tabel Data -->
    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Tanggal</th>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border">No RM</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                <tr>
                    <td class="p-2 border">{{ $item->idtransaksi }}</td>
                    <td class="p-2 border">{{ $item->tanggal->format('d-m-Y') }}</td>
                    <td class="p-2 border">{{ $item->nama }}</td>
                    <td class="p-2 border">{{ $item->norm }}</td>
                    <td class="p-2 border">
                        <button wire:click="edit({{ $item->id }})"
                            class="bg-yellow-400 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="delete({{ $item->id }})"
                            class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
