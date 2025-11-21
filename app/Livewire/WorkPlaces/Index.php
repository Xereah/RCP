<?php

namespace App\Livewire\WorkPlaces;

use App\Models\WorkPlace;
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
        $workPlaces = WorkPlace::paginate();

        return view('livewire.work-place.index', compact('workPlaces'))
            ->with('i', $this->getPage() * $workPlaces->perPage());
    }

    public function delete(WorkPlace $workPlace)
    {
        $workPlace->delete();

        return $this->redirectRoute('work-places.index', navigate: true);
    }
}
