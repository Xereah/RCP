<?php

namespace App\Livewire\Positions;

use App\Livewire\Forms\PositionForm;
use App\Models\Position;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public PositionForm $form;

    public function mount(Position $position)
    {
        $this->form->setPositionModel($position);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('positions.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.position.create');
    }
}
