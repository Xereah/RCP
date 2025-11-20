<?php

namespace App\Livewire\Personels;

use App\Models\Personel;
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
        $personels = Personel::paginate();

        return view('livewire.personel.index', compact('personels'))
            ->with('i', $this->getPage() * $personels->perPage());
    }

    public function delete(Personel $personel)
    {
        $personel->delete();

        return $this->redirectRoute('personels.index', navigate: true);
    }
}
