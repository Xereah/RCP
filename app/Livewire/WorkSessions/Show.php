<?php

namespace App\Livewire\WorkSessions;

use App\Livewire\Forms\WorkSessionForm;
use App\Models\WorkSession;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public WorkSessionForm $form;

    public function mount(WorkSession $workSession)
    {
        $this->form->setWorkSessionModel($workSession);
    }

    public function render()
    {
        return view('livewire.work-session.show', ['workSession' => $this->form->workSessionModel]);
    }
}
