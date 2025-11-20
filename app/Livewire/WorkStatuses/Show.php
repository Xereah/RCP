<?php

namespace App\Livewire\WorkStatuses;

use App\Livewire\Forms\WorkStatusForm;
use App\Models\WorkStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public WorkStatusForm $form;

    public function mount(WorkStatus $workStatus)
    {
        $this->form->setWorkStatusModel($workStatus);
    }

    public function render()
    {
        return view('livewire.work-status.show', ['workStatus' => $this->form->workStatusModel]);
    }
}
