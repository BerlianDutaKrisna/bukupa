<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UnitAsal;

class UnitAsalCrud extends Component
{
    public $unit_asal_id, $nama;
    public $updateMode = false;

    protected $rules = [
        'nama' => 'required|string|max:255'
    ];

    public function render()
    {
        return view('livewire.unit-asal-crud', [
            'units' => UnitAsal::latest()->get()
        ]);
    }

    public function resetInput()
    {
        $this->unit_asal_id = null;
        $this->nama = '';
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate();
        UnitAsal::create(['nama' => $this->nama]);
        session()->flash('message', 'Unit Asal berhasil ditambahkan.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $unit = UnitAsal::findOrFail($id);
        $this->unit_asal_id = $unit->id;
        $this->nama = $unit->nama;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();
        $unit = UnitAsal::find($this->unit_asal_id);
        $unit->update(['nama' => $this->nama]);
        session()->flash('message', 'Unit Asal berhasil diperbarui.');
        $this->resetInput();
    }

    public function delete($id)
    {
        UnitAsal::find($id)->delete();
        session()->flash('message', 'Unit Asal berhasil dihapus.');
    }
}
