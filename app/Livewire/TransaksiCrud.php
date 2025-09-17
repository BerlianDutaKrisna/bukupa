<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;

class TransaksiCrud extends Component
{
    public $transaksi, $idtransaksi, $tanggal, $idpasien, $norm, $nama;
    public $tgl_lhr, $pasien_usia, $beratbadan, $tinggibadan, $alamat, $jeniskelamin, $kota;
    public $updateMode = false;
    public $transaksiId; // <-- tambahkan properti ini

    public function render()
    {
        $this->transaksi = Transaksi::latest()->get();
        return view('livewire.transaksi-crud');
    }

    private function resetInputFields()
    {
        $this->idtransaksi = '';
        $this->tanggal = '';
        $this->idpasien = '';
        $this->norm = '';
        $this->nama = '';
        $this->tgl_lhr = '';
        $this->pasien_usia = '';
        $this->beratbadan = '';
        $this->tinggibadan = '';
        $this->alamat = '';
        $this->jeniskelamin = '';
        $this->kota = '';
        $this->transaksiId = null; // reset id juga
    }

    public function store()
    {
        $this->validate([
            'idtransaksi' => 'required|unique:transaksi',
            'tanggal' => 'required|date',
            'nama' => 'required',
        ]);

        Transaksi::create([
            'idtransaksi' => $this->idtransaksi,
            'tanggal' => $this->tanggal,
            'idpasien' => $this->idpasien,
            'norm' => $this->norm,
            'nama' => $this->nama,
            'tgl_lhr' => $this->tgl_lhr,
            'pasien_usia' => $this->pasien_usia,
            'beratbadan' => $this->beratbadan,
            'tinggibadan' => $this->tinggibadan,
            'alamat' => $this->alamat,
            'jeniskelamin' => $this->jeniskelamin,
            'kota' => $this->kota,
        ]);

        session()->flash('success', 'Transaksi berhasil ditambahkan!');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $record = Transaksi::findOrFail($id);
        $this->updateMode = true;

        $this->transaksiId = $id; // simpan id ke variabel baru
        $this->idtransaksi = $record->idtransaksi;
        $this->tanggal = $record->tanggal->toDateString();
        $this->idpasien = $record->idpasien;
        $this->norm = $record->norm;
        $this->nama = $record->nama;
        $this->tgl_lhr = $record->tgl_lhr;
        $this->pasien_usia = $record->pasien_usia;
        $this->beratbadan = $record->beratbadan;
        $this->tinggibadan = $record->tinggibadan;
        $this->alamat = $record->alamat;
        $this->jeniskelamin = $record->jeniskelamin;
        $this->kota = $record->kota;
    }

    public function update()
    {
        $this->validate([
            'idtransaksi' => 'required',
            'tanggal' => 'required|date',
            'nama' => 'required',
        ]);

        $record = Transaksi::find($this->transaksiId); // gunakan transaksiId
        $record->update([
            'idtransaksi' => $this->idtransaksi,
            'tanggal' => $this->tanggal,
            'idpasien' => $this->idpasien,
            'norm' => $this->norm,
            'nama' => $this->nama,
            'tgl_lhr' => $this->tgl_lhr,
            'pasien_usia' => $this->pasien_usia,
            'beratbadan' => $this->beratbadan,
            'tinggibadan' => $this->tinggibadan,
            'alamat' => $this->alamat,
            'jeniskelamin' => $this->jeniskelamin,
            'kota' => $this->kota,
        ]);

        $this->updateMode = false;
        session()->flash('success', 'Transaksi berhasil diperbarui!');
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Transaksi::find($id)->delete();
        session()->flash('success', 'Transaksi berhasil dihapus!');
    }
}