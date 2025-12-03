<?php

declare(strict_types=1);

namespace App\Livewire\WorkTimeRegulations;

use App\Livewire\Forms\WorkTimeRegulationForm;
use App\Models\WorkTimeRegulation;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public WorkTimeRegulationForm $form;

    public function mount(WorkTimeRegulation $workTimeRegulation)
    {
        $this->form->setWorkTimeRegulationModel($workTimeRegulation);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('work-time-regulations.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.work-time-regulation.create');
    }
}

