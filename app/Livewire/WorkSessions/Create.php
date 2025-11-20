<?php

declare(strict_types=1);

namespace App\Livewire\WorkSessions;

use App\Livewire\Concerns\WithPersonelPicker;
use App\Livewire\Forms\WorkSessionForm;
use App\Models\WorkSession;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WorkStatus;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

#[Layout('layouts.app')]
class Create extends Component
{
    use WithPersonelPicker;

    public WorkSessionForm $form;

    public EloquentCollection $workStatuses;

    public function mount(WorkSession $workSession)
    {
        $this->form->setWorkSessionModel($workSession);
        $this->workStatuses = WorkStatus::all();
        $this->syncSelectedPersonel();
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
