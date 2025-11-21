<?php

namespace App\Livewire\WorkPlaces;

use App\Livewire\Forms\WorkPlaceForm;
use App\Models\WorkPlace;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public WorkPlaceForm $form;

    public function mount(WorkPlace $workPlace)
    {
        $this->form->setWorkPlaceModel($workPlace);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('work-places.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.work-place.create');
    }
}
