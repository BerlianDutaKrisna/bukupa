<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pemeriksaan;

class PemeriksaanCrud extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 25;

    // Untuk create/update
    public $pemeriksaanId;
    public $tanggal_pemeriksaan;
    public $status;
    public $status_lokasi;
    public $diagnosa_klinik;
    public $id_pasien;
    public $id_user;

    public function render()
    {
        $query = Pemeriksaan::with(['pasien', 'user'])
            ->when($this->search, function ($q) {
                $q->whereHas('pasien', function ($pasien) {
                    $pasien->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('norm', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('tanggal_pemeriksaan', 'desc');

        $pemeriksaans = $query->paginate($this->perPage);

        return view('livewire.pemeriksaan-crud', [
            'pemeriksaans' => $pemeriksaans,
        ]);
    }

    public function resetInput()
    {
        $this->pemeriksaanId = null;
        $this->tanggal_pemeriksaan = null;
        $this->status = null;
        $this->status_lokasi = null;
        $this->diagnosa_klinik = null;
        $this->id_pasien = null;
        $this->id_user = null;
    }

    public function store()
    {
        $this->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'status' => 'nullable|string',
            'status_lokasi' => 'nullable|string',
            'diagnosa_klinik' => 'nullable|string',
            'id_pasien' => 'required|exists:pasiens,id',
            'id_user' => 'required|exists:users,id',
        ]);

        Pemeriksaan::create([
            'tanggal_pemeriksaan' => $this->tanggal_pemeriksaan,
            'status' => $this->status,
            'status_lokasi' => $this->status_lokasi,
            'diagnosa_klinik' => $this->diagnosa_klinik,
            'id_pasien' => $this->id_pasien,
            'id_user' => $this->id_user,
        ]);

        session()->flash('success', 'Pemeriksaan berhasil ditambahkan.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $periksa = Pemeriksaan::findOrFail($id);
        $this->pemeriksaanId = $periksa->id;
        $this->tanggal_pemeriksaan = $periksa->tanggal_pemeriksaan;
        $this->status = $periksa->status;
        $this->status_lokasi = $periksa->status_lokasi;
        $this->diagnosa_klinik = $periksa->diagnosa_klinik;
        $this->id_pasien = $periksa->id_pasien;
        $this->id_user = $periksa->id_user;
    }

    public function update()
    {
        $this->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'id_pasien' => 'required|exists:pasiens,id',
            'id_user' => 'required|exists:users,id',
        ]);

        $periksa = Pemeriksaan::findOrFail($this->pemeriksaanId);
        $periksa->update([
            'tanggal_pemeriksaan' => $this->tanggal_pemeriksaan,
            'status' => $this->status,
            'status_lokasi' => $this->status_lokasi,
            'diagnosa_klinik' => $this->diagnosa_klinik,
            'id_pasien' => $this->id_pasien,
            'id_user' => $this->id_user,
        ]);

        session()->flash('success', 'Pemeriksaan berhasil diperbarui.');
        $this->resetInput();
    }

    public function delete($id)
    {
        Pemeriksaan::findOrFail($id)->delete();
        session()->flash('success', 'Pemeriksaan berhasil dihapus.');
    }
}
