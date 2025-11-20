<?php

namespace App\Livewire\WorkSessions;

use App\Models\WorkSession;
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
        $workSessions = WorkSession::paginate();

        return view('livewire.work-session.index', compact('workSessions'))
            ->with('i', $this->getPage() * $workSessions->perPage());
    }

    public function delete(WorkSession $workSession)
    {
        $workSession->delete();

        return $this->redirectRoute('work-sessions.index', navigate: true);
    }
}
