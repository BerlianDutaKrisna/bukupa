<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Dashboard extends Component
{
    use WithFileUploads;

    public string $appName = 'Dashboard Pasien';
    public string $searchNorm = '';
    public array $tanggalPemeriksaan = [];
    public $pasiens;
    public $pemeriksaan;
    public $pemeriksaanAll;
    public array $expanded = [];
    public bool $loading = false;
    public $editingStatusId = null;

    // Foto & modal viewer
    public $foto_unit_asal;
    public bool $viewerOpen = false;
    public $currentFoto;
    public $pemeriksaanId;

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
            $pasien = Pasien::where('norm', $this->searchNorm)->get();

            if ($pasien->count() > 0) {
                $this->pasiens = $pasien;
            } else {
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

        $this->searchNorm = '';
        $this->pasiens = collect([]);
        $this->tanggalPemeriksaan[$idPasien] = now()->toDateString();

        session()->flash('success', 'Pemeriksaan berhasil ditambahkan.');
        $this->dispatch('focus-search');
    }

    public function loadPemeriksaanHariIni()
    {
        $this->pemeriksaan = Pemeriksaan::with(['pasien', 'user.unitAsal'])
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
            ->map->all();
    }

    public function updateField($id, $field, $value)
    {
        $periksa = Pemeriksaan::find($id);
        if ($periksa && in_array($field, $periksa->getFillable())) {
            $periksa->update([$field => $value]);
        }
        $this->loadPemeriksaanHariIni();
        $this->loadPemeriksaanAll();
    }

    public function updateStatus($id, $value)
    {
        $periksa = Pemeriksaan::find($id);
        if ($periksa && in_array('status', $periksa->getFillable())) {
            $periksa->update(['status' => $value]);
        }
        $this->loadPemeriksaanHariIni();
        $this->loadPemeriksaanAll();
        $this->editingStatusId = null;
        session()->flash('success', 'Status berhasil diperbarui.');
    }

    // Foto
    public function setPemeriksaan($id)
    {
        $this->pemeriksaanId = $id;
    }

    public function openViewer($id)
    {
        $this->pemeriksaanId = $id;
        $pemeriksaan = Pemeriksaan::find($id);
        $this->currentFoto = $pemeriksaan?->foto_unit_asal;
        $this->viewerOpen = true;
    }

    public function closeViewer()
    {
        $this->viewerOpen = false;
        $this->foto_unit_asal = null;
    }

    public function uploadFoto()
    {
        if ($this->pemeriksaanId && $this->foto_unit_asal) {
            $path = $this->foto_unit_asal->store('foto_unit_asal', 'public');
            $pemeriksaan = Pemeriksaan::find($this->pemeriksaanId);

            if ($pemeriksaan) {
                if ($pemeriksaan->foto_unit_asal && Storage::disk('public')->exists($pemeriksaan->foto_unit_asal)) {
                    Storage::disk('public')->delete($pemeriksaan->foto_unit_asal);
                }
                $pemeriksaan->update(['foto_unit_asal' => $path]);
                $this->currentFoto = $path;
            }
            $this->foto_unit_asal = null;
            session()->flash('success', 'Foto berhasil diupload.');
        }
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'pasiens'        => $this->pasiens ?? collect(),
            'pemeriksaan'    => $this->pemeriksaan ?? collect(),
            'pemeriksaanAll' => $this->pemeriksaanAll ?? collect(),
            'editingStatusId' => $this->editingStatusId,
            'foto_unit_asal' => $this->foto_unit_asal,
            'viewerOpen'     => $this->viewerOpen,
            'currentFoto'    => $this->currentFoto,
        ]);
    }
}
