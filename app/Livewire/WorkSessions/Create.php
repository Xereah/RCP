<?php

namespace App\Livewire\WorkSessions;

use App\Livewire\Forms\WorkSessionForm;
use App\Models\WorkSession;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Personel;
use App\Models\WorkStatus;

#[Layout('layouts.app')]
class Create extends Component
{
    public WorkSessionForm $form;

    public $personels;
    public $workStatuses;

    public function mount(WorkSession $workSession)
    {
        $this->form->setWorkSessionModel($workSession);
        $this->personels = Personel::all();
        $this->workStatuses = WorkStatus::all();
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('work-sessions.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.work-session.create');
    }
}
