<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pemeriksaan;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PemeriksaanCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $foto_unit_asal = null;
    public $viewerOpen = false;
    public $currentFoto = null;
    public $pemeriksaanId = null;
    public $editingStatusId = null;
    public $tanggalPemeriksaan = [];
    public $expanded = [];


    public $search = '';
    public $perPage = 25;

    // Untuk create/update
    public $tanggal_pemeriksaan;
    public $status;
    public $status_lokasi;
    public $diagnosa_klinik;
    public $id_pasien;
    public $id_user;

    public function render()
    {
        // contoh query: ganti sesuai kebutuhanmu (filter tanggal, paginate, dsb.)
        $pemeriksaan = \App\Models\Pemeriksaan::with(['pasien', 'user'])
            ->whereDate('tanggal_pemeriksaan', now()->toDateString())
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        $pemeriksaanAll = \App\Models\Pemeriksaan::with(['pasien', 'user'])
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        return view('livewire.dashboard', [
            'pemeriksaan' => $pemeriksaan,
            'pemeriksaanAll' => $pemeriksaanAll,
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

    public function setPemeriksaan($id)
    {
        $this->pemeriksaanId = $id;
    }

    public function openViewer($id)
    {
        $this->pemeriksaanId = $id;
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        $this->currentFoto = $pemeriksaan->foto_unit_asal;
        $this->viewerOpen = true;
    }

    public function closeViewer()
    {
        $this->viewerOpen = false;
        $this->foto_unit_asal = null;
    }

    public function uploadFoto()
    {
        $this->validate([
            'foto_unit_asal' => 'required|file|mimes:jpg,jpeg,png,webp,gif',
        ]);

        $pemeriksaan = Pemeriksaan::findOrFail($this->pemeriksaanId);

        // hapus foto lama kalau ada
        if ($pemeriksaan->foto_unit_asal && Storage::disk('public')->exists($pemeriksaan->foto_unit_asal)) {
            Storage::disk('public')->delete($pemeriksaan->foto_unit_asal);
        }

        // simpan file baru
        $path = $this->foto_unit_asal->store('foto_unit_asal', 'public');

        // update database
        $pemeriksaan->update([
            'foto_unit_asal' => $path,
        ]);

        session()->flash('success', 'Foto berhasil diupload.');
        $this->foto_unit_asal = null;
    }

    public function delete($id)
    {
        Pemeriksaan::findOrFail($id)->delete();
        session()->flash('success', 'Pemeriksaan berhasil dihapus.');
    }
}
