@foreach ($pemeriksaanAll as $tanggal => $listPemeriksaan)
    @php
        $tanggalParts = explode(',', $tanggal);
        $tanggalOnly = trim($tanggalParts[1] ?? $tanggalParts[0]);
        $parsedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $tanggalOnly);
        $isFuture = $parsedDate->isFuture();
    @endphp

    <h3 class="{{ $isFuture ? 'bg-gray-300' : 'bg-green-300' }} text-gray-800 font-bold px-3 py-2 rounded mt-4">
        {{ $tanggal }}
    </h3>

    <table class="min-w-full border {{ $isFuture ? 'border-gray-300' : 'border-green-300' }} mb-6">
        <thead>
            <tr class="{{ $isFuture ? 'bg-gray-200' : 'bg-green-200' }} text-left">
                <th class="p-2 border">No</th>
                <th class="p-2 border">Pasien</th>
                <th class="p-2 border">Lokasi & Diagnosa</th>
                <th class="p-2 border">Unit Asal</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Unit PA</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($listPemeriksaan as $index => $periksa)
                <tr class="hover:bg-gray-100 align-top">
                    <td class="p-2 border">{{ $index + 1 }}</td>

                    <!-- Pasien -->
                    <td class="p-2 border">
                        <div>
                            <strong>{{ $periksa['pasien']['nama'] ?? '-' }}
                                ({{ $periksa['pasien']['jenkel'] ?? '-' }})
                            </strong>
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $periksa['pasien']['norm'] ?? '-' }} {{ $periksa['pasien']['tgl_lhr'] ?? '-' }}
                        </div>
                        <div class="text-sm text-gray-500">{{ $periksa['pasien']['alamat'] ?? '-' }}</div>
                    </td>

                    <!-- Lokasi & Diagnosa -->
                    <td class="p-2 border">
                        <input type="text"
                            wire:change="updateField({{ $periksa['id'] }}, 'status_lokasi', $event.target.value)"
                            value="{{ $periksa['status_lokasi'] }}" class="w-full border rounded p-1 mb-1"
                            placeholder="Lokasi" />
                        <div class="text-sm text-gray-700">{{ $periksa['diagnosa_klinik'] ?? '-' }}</div>
                    </td>

                    <!-- Unit Asal -->
                    <td class="p-2 border">
                        <div>
                            {{ $periksa['user']['nama'] ?? '-' }}
                            ({{ $periksa['user']['unit_asal']['nama'] ?? '-' }})
                        </div>
                        <input type="text"
                            wire:change="updateField({{ $periksa['id'] }}, 'pesan_unit_asal', $event.target.value)"
                            value="{{ $periksa['pesan_unit_asal'] }}" class="w-full border rounded p-1 mt-1 text-sm"
                            placeholder="Pesan Unit Asal" />
                    </td>

                    <!-- Status -->
                    <td class="p-2 border text-center align-middle">
                        <div class="flex items-center justify-center h-full">
                            @if ($editingStatusId === $periksa['id'])
                                <div>
                                    <select wire:change="updateStatus({{ $periksa['id'] }}, $event.target.value)"
                                        class="w-full border rounded px-2 py-1 text-sm">
                                        <option value="On Process"
                                            {{ $periksa['status'] === 'On Process' ? 'selected' : '' }}>On Process
                                        </option>
                                        <option value="Registered"
                                            {{ $periksa['status'] === 'Registered' ? 'selected' : '' }}>Registered
                                        </option>
                                        <option value="Accepted"
                                            {{ $periksa['status'] === 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="Canceled"
                                            {{ $periksa['status'] === 'Canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </div>
                            @else
                                <span wire:click="$set('editingStatusId', {{ $periksa['id'] }})"
                                    @class([
                                        'px-3 py-1 rounded-full text-xs cursor-pointer inline-block',
                                        'bg-gray-200 text-gray-800' => $periksa['status'] === 'On Process',
                                        'bg-yellow-200 text-yellow-800' => $periksa['status'] === 'Registered',
                                        'bg-green-200 text-green-800' => $periksa['status'] === 'Accepted',
                                        'bg-red-200 text-red-800' => $periksa['status'] === 'Canceled',
                                        'bg-gray-100 text-gray-800' => is_null($periksa['status']),
                                    ])>
                                    {{ $periksa['status'] ?? 'Pilih Status' }}
                                </span>
                            @endif
                        </div>
                    </td>

                    <!-- Unit PA -->
                    <td class="p-2 border">
                        <div>{{ $periksa['nama_user_pa'] ?? '-' }}</div>
                        <input type="text"
                            wire:change="updateField({{ $periksa['id'] }}, 'pesan_pa', $event.target.value)"
                            value="{{ $periksa['pesan_pa'] }}" class="w-full border rounded p-1 mt-1 text-sm"
                            placeholder="Pesan PA" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 p-4">
                        Tidak ada pemeriksaan pada tanggal ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endforeach
