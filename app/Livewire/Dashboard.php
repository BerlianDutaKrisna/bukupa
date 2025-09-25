<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Dashboard extends Component
{
    public string $appName = 'Dashboard Pasien';
    public string $searchNorm = '';
    public array $tanggalPemeriksaan = [];
    public $pasiens;
    public $pemeriksaan;
    public $pemeriksaanAll;
    public array $expanded = [];
    public bool $loading = false;
    public $editingStatusId = null;

    public function mount()
    {
        $this->pasiens = collect([]);
        $this->pemeriksaan = collect([]);
        $this->pemeriksaanAll = collect([]);
        foreach (Pasien::all() as $pasien) {
            $this->tanggalPemeriksaan[$pasien->id] = now()->toDateString();
        }
        $this->loadPemeriksaanHariIni();
        $this->loadPemeriksaanAll();
    }

    public function searchPasien()
    {
        if (empty($this->searchNorm)) {
            $this->pasiens = collect();
            return;
        }

        $this->loading = true;

        try {
            // Cari di database lokal
            $pasien = Pasien::where('norm', $this->searchNorm)->get();

            if ($pasien->count() > 0) {
                $this->pasiens = $pasien;
            } else {
                // Panggil API eksternal
                $response = Http::timeout(5)->get("http://172.20.29.240/apibdrs/apibdrs/getPasien/{$this->searchNorm}");

                if ($response->successful()) {
                    $json = $response->json();

                    if (isset($json['data']) && !empty($json['data'])) {
                        $data = $json['data'];

                        $newPasien = Pasien::updateOrCreate(
                            ['norm' => $data['norm']],
                            [
                                'idpasien' => $data['id'] ?? null,
                                'nik'      => $data['nik'] ?? null,
                                'nama'     => $data['nama'] ?? null,
                                'alamat'   => $data['alamat'] ?? null,
                                'kota'     => $data['kota'] ?? null,
                                'jenkel'   => $data['jenkel'] ?? null,
                                'tgl_lhr'  => $data['tgl_lhr'] ?? null,
                            ]
                        );

                        $this->pasiens = collect([$newPasien]);
                    } else {
                        $this->pasiens = collect();
                    }
                } else {
                    $this->pasiens = collect();
                }
            }
        } catch (\Exception $e) {
            $this->pasiens = collect();
        } finally {
            $this->loading = false;
        }
    }

    public function toggleDetail($id)
    {
        if (isset($this->expanded[$id])) {
            unset($this->expanded[$id]);
        } else {
            $this->expanded[$id] = true;
        }
    }

    public function tambahPemeriksaan($idPasien)
    {
        $tanggal = $this->tanggalPemeriksaan[$idPasien] ?? now()->toDateString();

        Pemeriksaan::create([
            'id_transaksi'        => null,
            'id_pasien'           => $idPasien,
            'id_user'             => Auth::id(),
            'tanggal_pemeriksaan' => $tanggal,
            'status'              => 'On Process',
        ]);

        $this->loadPemeriksaanHariIni();
        $this->loadPemeriksaanAll();

        // Reset pencarian
        $this->searchNorm = '';
        $this->pasiens = collect([]);

        // Set tanggal default lagi ke hari ini
        $this->tanggalPemeriksaan[$idPasien] = now()->toDateString();

        session()->flash('success', 'Pemeriksaan berhasil ditambahkan.');

        // Kembalikan fokus ke input pencarian
        $this->dispatch('focus-search');
    }

    public function loadPemeriksaanHariIni()
    {
        $this->pemeriksaan = Pemeriksaan::with(['pasien', 'user'])
            ->whereDate('tanggal_pemeriksaan', now()->toDateString())
            ->get();

    }

    public function loadPemeriksaanAll()
    {
        $this->pemeriksaan = Pemeriksaan::with(['pasien', 'user.unitAsal'])
            ->whereDate('tanggal_pemeriksaan', now()->toDateString())
            ->get();

        $this->pemeriksaanAll = Pemeriksaan::with(['pasien', 'user.unitAsal'])
            ->whereDate('tanggal_pemeriksaan', '!=', now()->toDateString())
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_pemeriksaan)
                    ->locale('id')
                    ->translatedFormat('l, d-m-Y');
            })
            ->map(fn($group) => $group->map(fn($item) => $item->toArray()))
            ->toArray();
    }

    public function updateField($id, $field, $value)
    {
        $periksa = Pemeriksaan::find($id);

        if ($periksa && in_array($field, $periksa->getFillable())) {
            $periksa->update([
                $field => $value,
            ]);
        }

        // Refresh data setelah update
        $this->loadPemeriksaanHariIni();
        $this->loadPemeriksaanAll();
    }

    public function setEditingStatus($id)
    {
        $this->editingStatusId = $id;
    }

    public function cancelEditingStatus()
    {
        $this->editingStatusId = null;
    }

    public function updateStatus($id, $value)
    {
        $periksa = Pemeriksaan::find($id);

        if (! $periksa) {
            return;
        }

        if (in_array('status', $periksa->getFillable())) {
            $periksa->update(['status' => $value]);
        }

        // Refresh data
        $this->loadPemeriksaanHariIni();
        $this->loadPemeriksaanAll();

        $this->editingStatusId = null;

        session()->flash('success', 'Status berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'pasiens'        => $this->pasiens ?? collect(),
            'pemeriksaan'    => $this->pemeriksaan ?? collect(),
            'pemeriksaanAll' => $this->pemeriksaanAll ?? collect(),
        ]);
    }
}
