<?php

namespace App\Livewire\Positions;

use App\Livewire\Forms\PositionForm;
use App\Models\Position;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public PositionForm $form;

    public function mount(Position $position)
    {
        $this->form->setPositionModel($position);
    }

    public function render()
    {
        return view('livewire.position.show', ['position' => $this->form->positionModel]);
    }
}
