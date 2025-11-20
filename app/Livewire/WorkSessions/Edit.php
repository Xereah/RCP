<?php

namespace App\Livewire\WorkSessions;

use App\Livewire\Forms\WorkSessionForm;
use App\Models\WorkSession;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Edit extends Component
{
    public WorkSessionForm $form;

    public function mount(WorkSession $workSession)
    {
        $this->form->setWorkSessionModel($workSession);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('work-sessions.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.work-session.edit');
    }
}
