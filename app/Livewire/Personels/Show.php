<?php

namespace App\Livewire\Personels;

use App\Livewire\Forms\PersonelForm;
use App\Models\Personel;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]    
class Show extends Component
{
    public PersonelForm $form;

    public function mount(Personel $personel)
    {
        $this->form->setPersonelModel($personel);
    }

    public function render()
    {
        return view('livewire.personel.show', ['personel' => $this->form->personelModel]);
    }
}
