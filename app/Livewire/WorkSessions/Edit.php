<?php

declare(strict_types=1);

namespace App\Livewire\WorkSessions;

use App\Livewire\Concerns\WithPersonelPicker;
use App\Livewire\Forms\WorkSessionForm;
use App\Models\WorkSession;
use App\Models\WorkStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

#[Layout('layouts.app')]
class Edit extends Component
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
        $this->form->update();

        return $this->redirectRoute('work-sessions.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.work-session.edit');
    }
}
