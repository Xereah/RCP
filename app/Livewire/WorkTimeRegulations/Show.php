<?php

declare(strict_types=1);

namespace App\Livewire\WorkTimeRegulations;

use App\Models\WorkTimeRegulation;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public WorkTimeRegulation $workTimeRegulation;

    public function mount(WorkTimeRegulation $workTimeRegulation)
    {
        $this->workTimeRegulation = $workTimeRegulation;
    }

    public function render()
    {
        return view('livewire.work-time-regulation.show');
    }
}

