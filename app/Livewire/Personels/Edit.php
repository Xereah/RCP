<?php

namespace App\Livewire\Personels;

use App\Livewire\Forms\PersonelForm;
use App\Models\Personel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Position;

#[Layout('layouts.app')]    
class Edit extends Component
{
    public PersonelForm $form;

    public $positions;

    public function mount(Personel $personel)
    {
        $this->form->setPersonelModel($personel);
        $this->positions = Position::all();
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('personels.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.personel.edit');
    }
}
