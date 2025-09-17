<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pasien;

class PasienCrud extends Component
{
    public $pasiens;
    public $norm, $nik, $nama, $alamat, $kota, $jenkel, $tgl_lhr;
    public $selected_id;
    public $updateMode = false;
    public $showForm = false;

    public function render()
    {
        $this->pasiens = Pasien::all();
        return view('livewire.pasien-crud');
    }

    public function resetInputFields()
    {
        $this->norm = '';
        $this->nik = '';
        $this->nama = '';
        $this->alamat = '';
        $this->kota = '';
        $this->jenkel = '';
        $this->tgl_lhr = '';
        $this->selected_id = null;
        $this->updateMode = false;
        $this->showForm = false;
    }

    public function store()
    {
        $validatedData = $this->validate([
            'norm' => 'required|unique:pasien,norm',
            'nik' => 'nullable',
            'nama' => 'nullable',
            'alamat' => 'nullable',
            'kota' => 'nullable',
            'jenkel' => 'nullable',
            'tgl_lhr' => 'nullable|date',
        ]);

        Pasien::create($validatedData);

        session()->flash('message', 'Pasien berhasil ditambahkan.');

        $this->resetInputFields();
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        $this->selected_id = $pasien->id;
        $this->norm = $pasien->norm;
        $this->nik = $pasien->nik;
        $this->nama = $pasien->nama;
        $this->alamat = $pasien->alamat;
        $this->kota = $pasien->kota;
        $this->jenkel = $pasien->jenkel;
        $this->tgl_lhr = $pasien->tgl_lhr;

        $this->updateMode = true;
        $this->showForm = true; // tampilkan form
    }

    public function update()
    {
        $validatedData = $this->validate([
            'norm' => 'required|unique:pasien,norm,' . $this->selected_id,
            'nik' => 'nullable',
            'nama' => 'nullable',
            'alamat' => 'nullable',
            'kota' => 'nullable',
            'jenkel' => 'nullable',
            'tgl_lhr' => 'nullable|date',
        ]);

        if ($this->selected_id) {
            $pasien = Pasien::find($this->selected_id);
            $pasien->update($validatedData);
            session()->flash('message', 'Pasien berhasil diupdate.');
            $this->resetInputFields();
        }
    }

    public function delete($id)
    {
        if ($id) {
            Pasien::find($id)->delete();
            session()->flash('message', 'Pasien berhasil dihapus.');
        }
    }
}
