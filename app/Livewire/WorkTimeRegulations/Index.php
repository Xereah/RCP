<?php

declare(strict_types=1);

namespace App\Livewire\WorkTimeRegulations;

use App\Models\WorkTimeRegulation;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        $workTimeRegulations = WorkTimeRegulation::paginate();

        return view('livewire.work-time-regulation.index', compact('workTimeRegulations'))
            ->with('i', $this->getPage() * $workTimeRegulations->perPage());
    }

    public function delete(WorkTimeRegulation $workTimeRegulation)
    {
        $workTimeRegulation->delete();

        return $this->redirectRoute('work-time-regulations.index', navigate: true);
    }
}

