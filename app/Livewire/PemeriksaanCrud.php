<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Storage;

class PemeriksaanCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $foto_unit_asal = null;
    public $viewerOpen = false;
    public $currentFoto = null;
    public $pemeriksaanId = null;
    public $editingStatusId = null;
    public $search = '';
    public $perPage = 25;

    // Input form
    public $tanggal_pemeriksaan;
    public $status;
    public $status_lokasi;
    public $diagnosa_klinik;
    public $id_pasien;
    public $id_user;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $query = Pemeriksaan::with(['pasien', 'user'])->orderBy('tanggal_pemeriksaan', 'desc');

        if ($this->search) {
            $query->whereHas('pasien', function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            });
        }

        $pemeriksaan = $query->paginate($this->perPage);

        return view('livewire.pemeriksaan-crud', [
            'pemeriksaan' => $pemeriksaan,
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
        $this->foto_unit_asal = null;
        $this->viewerOpen = false;
        $this->currentFoto = null;
    }

    public function store()
    {
        $this->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'id_pasien' => 'required|exists:pasien,id',
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
            'id_pasien' => 'required|exists:pasien,id',
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

    // Foto Unit Asal
    public function setPemeriksaan($id)
    {
        $this->pemeriksaanId = $id;
    }

    public function openViewer($id)
    {
        $this->pemeriksaanId = $id;
        $periksa = Pemeriksaan::findOrFail($id);
        $this->currentFoto = $periksa->foto_unit_asal;
        $this->viewerOpen = true;
    }

    public function closeViewer()
    {
        $this->viewerOpen = false;
        $this->foto_unit_asal = null;
        $this->currentFoto = null;
    }

    public function uploadFoto()
    {
        $this->validate([
            'foto_unit_asal' => 'required|file|mimes:jpg,jpeg,png,webp,gif',
        ]);

        $periksa = Pemeriksaan::findOrFail($this->pemeriksaanId);

        if ($periksa->foto_unit_asal && Storage::disk('public')->exists($periksa->foto_unit_asal)) {
            Storage::disk('public')->delete($periksa->foto_unit_asal);
        }

        $path = $this->foto_unit_asal->store('foto_unit_asal', 'public');

        $periksa->update(['foto_unit_asal' => $path]);

        session()->flash('success', 'Foto berhasil diupload.');
        $this->foto_unit_asal = null;
    }
}
