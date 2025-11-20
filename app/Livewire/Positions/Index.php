<?php

namespace App\Livewire\Positions;

use App\Models\Position;
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
        $positions = Position::paginate();

        return view('livewire.position.index', compact('positions'))
            ->with('i', $this->getPage() * $positions->perPage());
    }

    public function delete(Position $position)
    {
        $position->delete();

        return $this->redirectRoute('positions.index', navigate: true);
    }
}
