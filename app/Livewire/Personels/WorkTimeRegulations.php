<?php

declare(strict_types=1);

namespace App\Livewire\Personels;

use App\Models\Personel;
use App\Models\PersonelWorkTimeRegulationHistory;
use App\Models\WorkTimeRegulation;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class WorkTimeRegulations extends Component
{
    public Personel $personel;
    public $regulations;
    public $history;
    
    // Form fields
    public $work_time_regulation_id = '';
    public $valid_from = '';
    public $valid_to = '';
    public $notes = '';
    public $editingId = null;

    public function mount(Personel $personel)
    {
        $this->personel = $personel->load('workTimeRegulationHistory.workTimeRegulation');
        $this->regulations = WorkTimeRegulation::where('is_active', true)->get();
        $this->refreshHistory();
    }

    public function refreshHistory()
    {
        $this->history = $this->personel->workTimeRegulationHistory()->with('workTimeRegulation')->get();
    }

    public function save()
    {
        $this->validate([
            'work_time_regulation_id' => 'required|exists:work_time_regulations,id',
            'valid_from' => 'required|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'notes' => 'nullable|string|max:500',
        ], [
            'work_time_regulation_id.required' => 'Wybierz regulamin czasu pracy',
            'valid_from.required' => 'Podaj datę rozpoczęcia',
            'valid_to.after_or_equal' => 'Data zakończenia musi być późniejsza lub równa dacie rozpoczęcia',
        ]);

        if ($this->editingId) {
            $historyEntry = PersonelWorkTimeRegulationHistory::find($this->editingId);
            $historyEntry->update([
                'work_time_regulation_id' => $this->work_time_regulation_id,
                'valid_from' => $this->valid_from,
                'valid_to' => $this->valid_to ?: null,
                'notes' => $this->notes,
            ]);
            session()->flash('message', 'Regulamin zaktualizowany pomyślnie!');
        } else {
            PersonelWorkTimeRegulationHistory::create([
                'personel_id' => $this->personel->id,
                'work_time_regulation_id' => $this->work_time_regulation_id,
                'valid_from' => $this->valid_from,
                'valid_to' => $this->valid_to ?: null,
                'notes' => $this->notes,
                'is_active' => true,
            ]);
            session()->flash('message', 'Regulamin dodany pomyślnie!');
        }

        $this->reset(['work_time_regulation_id', 'valid_from', 'valid_to', 'notes', 'editingId']);
        $this->refreshHistory();
    }

    public function edit($id)
    {
        $entry = PersonelWorkTimeRegulationHistory::find($id);
        
        $this->editingId = $id;
        $this->work_time_regulation_id = $entry->work_time_regulation_id;
        $this->valid_from = $entry->valid_from->format('Y-m-d');
        $this->valid_to = $entry->valid_to?->format('Y-m-d') ?? '';
        $this->notes = $entry->notes ?? '';
    }

    public function cancelEdit()
    {
        $this->reset(['work_time_regulation_id', 'valid_from', 'valid_to', 'notes', 'editingId']);
    }

    public function delete($id)
    {
        PersonelWorkTimeRegulationHistory::find($id)->delete();
        session()->flash('message', 'Regulamin usunięty pomyślnie!');
        $this->refreshHistory();
    }

    public function render()
    {
        return view('livewire.personel.work-time-regulations');
    }
}

