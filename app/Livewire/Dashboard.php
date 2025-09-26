<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Dashboard extends Component
{
    use WithFileUploads;

    public string $appName = 'Dashboard Pasien';
    public string $searchNorm = '';
    public array $tanggalPemeriksaan = [];
    public $pasiens;
    public $pemeriksaanHariIni;
    public $pemeriksaanLain;
    public array $expanded = [];
    public bool $loading = false;
    public $editingStatusId = null;

    public $foto_unit_asal;
    public bool $viewerOpen = false;
    public $currentFoto;
    public $pemeriksaanId;

    public function mount()
    {
        $this->pasiens = collect([]);
        $this->pemeriksaanHariIni = collect([]);
        $this->pemeriksaanLain = collect([]);
        foreach (Pasien::all() as $pasien) {
            $this->tanggalPemeriksaan[$pasien->id] = now()->toDateString();
        }
        $this->loadPemeriksaanHariIni();
        $this->loadPemeriksaanLain();
    }

    public function searchPasien()
    {
        $this->loading = true;
        session()->forget('search_error'); // Clear previous error

        if (empty($this->searchNorm)) {
            $this->pasiens = collect();
            $this->loading = false;
            return;
        }

        try {
            // Cek database lokal
            $pasien = Pasien::where('norm', $this->searchNorm)->get();

            if ($pasien->count() > 0) {
                $this->pasiens = $pasien;
            } else {
                // Ambil dari API eksternal
                $response = Http::timeout(10)
                    ->get("http://172.20.29.240/apibdrs/apibdrs/getPasien/{$this->searchNorm}");

                if ($response->successful()) {
                    $json = $response->json();
                    if (!empty($json['data'])) {
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
                        session()->flash('search_error', 'Pasien tidak ditemukan di API.');
                        $this->dispatchBrowserEvent('console-log', ['message' => 'Pasien tidak ditemukan di API.']);
                    }
                } else {
                    $this->pasiens = collect();
                    session()->flash('search_error', 'Gagal menghubungi API. Response code: ' . $response->status());
                    $this->dispatchBrowserEvent('console-log', [
                        'message' => 'searchPasien API failed, status: ' . $response->status() . ', norm: ' . $this->searchNorm
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->pasiens = collect();
            session()->flash('search_error', 'Terjadi error saat mencari pasien: ' . $e->getMessage());
            $this->dispatchBrowserEvent('console-log', [
                'message' => 'searchPasien Exception: ' . $e->getMessage() . ', norm: ' . $this->searchNorm
            ]);
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
        $this->loadPemeriksaanLain();
        $this->searchNorm = '';
        $this->pasiens = collect([]);
        $this->tanggalPemeriksaan[$idPasien] = now()->toDateString();
        session()->flash('success', 'Pemeriksaan berhasil ditambahkan.');
        $this->dispatch('focus-search');
    }

    public function loadPemeriksaanHariIni()
    {
        $this->pemeriksaanHariIni = Pemeriksaan::with(['pasien', 'user.unitAsal'])
            ->whereDate('tanggal_pemeriksaan', now()->toDateString())
            ->get();
    }

    public function loadPemeriksaanLain()
    {
        $this->pemeriksaanLain = Pemeriksaan::with(['pasien', 'user.unitAsal'])
            ->whereDate('tanggal_pemeriksaan', '!=', now()->toDateString())
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal_pemeriksaan)
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
        $this->loadPemeriksaanLain();
    }

    public function updateStatus($id, $value)
    {
        $periksa = Pemeriksaan::find($id);
        if ($periksa && in_array('status', $periksa->getFillable())) {
            $periksa->update(['status' => $value]);
        }
        $this->loadPemeriksaanHariIni();
        $this->loadPemeriksaanLain();
        $this->editingStatusId = null;
        session()->flash('success', 'Status berhasil diperbarui.');
    }

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
            'pasiens'             => $this->pasiens,
            'pemeriksaan'         => $this->pemeriksaanHariIni,
            'pemeriksaanAll'      => $this->pemeriksaanLain,
            'editingStatusId'     => $this->editingStatusId,
            'foto_unit_asal'      => $this->foto_unit_asal,
            'viewerOpen'          => $this->viewerOpen,
            'currentFoto'         => $this->currentFoto,
        ]);
    }
}
