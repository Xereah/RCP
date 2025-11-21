<?php

namespace App\Livewire\Personels;

use App\Livewire\Forms\PersonelForm;
use App\Models\Personel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Position;
use App\Models\WorkPlace;

#[Layout('layouts.app')]
class Create extends Component
{
    public PersonelForm $form;

    public $positions;
    public $workPlaces;

    public function mount(Personel $personel)
    {
        $this->form->setPersonelModel($personel);
        $this->positions = Position::all();
        $this->workPlaces = WorkPlace::all();
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('personels.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.personel.create');
    }
}
