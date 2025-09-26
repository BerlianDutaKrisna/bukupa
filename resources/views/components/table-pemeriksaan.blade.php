@props(['pemeriksaan', 'editingStatusId' => null, 'pemeriksaanInput'])

<table class="min-w-full border border-sky-300 mb-6">
    <thead>
        <tr class="bg-sky-300 text-left">
            <th class="p-2 border">No</th>
            <th class="p-2 border">Pasien</th>
            <th class="p-2 border">Lokasi, Diagnosa dan Dokter</th>
            <th class="p-2 border">Unit Asal</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Unit PA</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pemeriksaan as $index => $periksa)
            <tr wire:key="pemeriksaan-{{ $periksa->id }}" class="hover:bg-gray-100 align-top">
                <td class="p-2 border">{{ $index + 1 }}</td>

                <td class="p-2 border">
                    <strong>{{ $periksa->pasien->nama ?? '-' }} ({{ $periksa->pasien->jenkel ?? '-' }})</strong>
                    <div class="text-sm text-gray-600">
                        {{ $periksa->pasien->norm ?? '-' }} {{ $periksa->pasien->tgl_lhr?->format('d-m-Y') ?? '-' }}
                    </div>
                    <div class="text-sm text-gray-500">{{ $periksa->pasien->alamat ?? '-' }}</div>
                </td>

                <td class="p-2 border">
                    <input type="text" wire:model.lazy="pemeriksaanInput.{{ $periksa->id }}.status_lokasi"
                        wire:blur="updateField({{ $periksa->id }}, 'status_lokasi')"
                        class="w-full border rounded p-1 mb-1" placeholder="Lokasi" />
                    <div class="text-sm">{{ $periksa->diagnosa_klinik ?? '-' }}</div>
                    <div class="text-sm"><strong>{{ $periksa->dokter_pengirim ?? '-' }}</strong></div>
                </td>

                <td class="p-2 border">
                    <div>{{ $periksa->user?->nama ?? '-' }} ({{ $periksa->user?->unitAsal?->nama ?? '-' }})</div>
                    <input type="text" wire:model.lazy="pemeriksaanInput.{{ $periksa->id }}.pesan_unit_asal"
                        wire:blur="updateField({{ $periksa->id }}, 'pesan_unit_asal')"
                        class="w-full border rounded p-1 mt-1 text-sm" placeholder="Pesan Unit Asal" />
                    <div class="text-sm mt-2 flex gap-3">
                        <button type="button" wire:click="openViewer({{ $periksa->id }})"
                            class="px-3 py-1.5 rounded-lg border text-sm">Lihat Foto</button>
                        <label wire:click="setPemeriksaan({{ $periksa->id }})"
                            class="px-3 py-1.5 rounded-lg cursor-pointer border text-sm">
                            Upload Foto
                            <input type="file" accept="image/*" wire:model="foto_unit_asal" class="hidden" />
                        </label>
                    </div>
                </td>

                <td class="p-2 border text-center align-middle">
                    <div class="flex items-center justify-center h-full">
                        @if ($editingStatusId === $periksa->id)
                            <select wire:change="updateStatus({{ $periksa->id }}, $event.target.value)"
                                class="w-full border rounded px-2 py-1 text-lg">
                                <option value="On Process" @selected($periksa->status === 'On Process')>On Process</option>
                                <option value="Registered" @selected($periksa->status === 'Registered')>Registered</option>
                                <option value="Accepted" @selected($periksa->status === 'Accepted')>Accepted</option>
                                <option value="Canceled" @selected($periksa->status === 'Canceled')>Canceled</option>
                                <option value="Uncompleted" @selected($periksa->status === 'Uncompleted')>Uncompleted</option>
                            </select>
                        @else
                            <span wire:click="$set('editingStatusId', {{ $periksa->id }})"
                                @class([
                                    'px-3 py-1 rounded-full text-lg cursor-pointer inline-block',
                                    'bg-gray-200 text-gray-800' => $periksa->status === 'On Process',
                                    'bg-yellow-200 text-yellow-800' => $periksa->status === 'Registered',
                                    'bg-green-200 text-green-800' => $periksa->status === 'Accepted',
                                    'bg-red-200 text-red-800' => $periksa->status === 'Canceled',
                                    'bg-purple-200 text-purple-800' => $periksa->status === 'Uncompleted',
                                    'bg-gray-100 text-gray-800' => is_null($periksa->status),
                                ])>
                                {{ $periksa->status ?? 'Pilih Status' }}
                            </span>
                        @endif
                    </div>
                </td>

                <td class="p-2 border">
                    <div>{{ $periksa->nama_user_pa ?? '-' }}</div>
                    <input type="text" wire:model.lazy="pemeriksaanInput.{{ $periksa->id }}.pesan_pa"
                        wire:blur="updateField({{ $periksa->id }}, 'pesan_pa')"
                        class="w-full border rounded p-1 mt-1 text-sm" placeholder="Pesan PA" />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-gray-500 p-4">Tidak ada pemeriksaan hari ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>
