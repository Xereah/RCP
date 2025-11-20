<?php

namespace App\Livewire\WorkStatuses;

use App\Models\WorkStatus;
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
        $workStatuses = WorkStatus::paginate();

        return view('livewire.work-status.index', compact('workStatuses'))
            ->with('i', $this->getPage() * $workStatuses->perPage());
    }

    public function delete(WorkStatus $workStatus)
    {
        $workStatus->delete();

        return $this->redirectRoute('work-statuses.index', navigate: true);
    }
}
