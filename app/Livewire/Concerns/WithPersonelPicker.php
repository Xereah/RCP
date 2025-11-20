<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Models\Personel;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

trait WithPersonelPicker
{
    public string $personelSearch = '';

    public bool $personelDropdownVisible = false;

    protected ?Personel $selectedPersonel = null;

    public function showPersonelDropdown(): void
    {
        $this->personelDropdownVisible = true;
    }

    public function hidePersonelDropdown(): void
    {
        $this->personelDropdownVisible = false;
    }

    public function updatedPersonelSearch(string $value): void
    {
        $this->personelDropdownVisible = true;

        if ($this->selectedPersonel && $value !== $this->formatPersonelLabel($this->selectedPersonel)) {
            $this->form->personel_id = null;
            $this->selectedPersonel = null;
        }
    }

    public function selectPersonel(int $personelId): void
    {
        $personel = Personel::query()
            ->with('position:id,name')
            ->findOrFail($personelId);

        $this->form->personel_id = $personel->id;
        $this->selectedPersonel = $personel;
        $this->personelSearch = $this->formatPersonelLabel($personel);
        $this->personelDropdownVisible = false;
    }

    public function getPersonelResultsProperty(): EloquentCollection
    {
        $query = Personel::query()
            ->with('position:id,name')
            ->where('is_active', true);

        if ($this->personelSearch !== '') {
            $term = $this->personelSearch;

            $query->where(function ($innerQuery) use ($term) {
                $innerQuery->where('last_name', 'like', "%{$term}%")
                    ->orWhere('first_name', 'like', "%{$term}%")
                    ->orWhere('personal_number', 'like', "%{$term}%");
            });
        }

        return $query
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->limit(10)
            ->get();
    }

    public function getSelectedPersonelLabelProperty(): ?string
    {
        return $this->selectedPersonel
            ? $this->formatPersonelLabel($this->selectedPersonel)
            : null;
    }

    protected function syncSelectedPersonel(): void
    {
        if (! $this->form->personel_id) {
            $this->selectedPersonel = null;
            $this->personelSearch = '';

            return;
        }

        $personel = Personel::query()
            ->with('position:id,name')
            ->find($this->form->personel_id);

        if (! $personel) {
            $this->form->personel_id = null;
            $this->personelSearch = '';
            $this->selectedPersonel = null;

            return;
        }

        $this->selectedPersonel = $personel;
        $this->personelSearch = $this->formatPersonelLabel($personel);
    }

    protected function formatPersonelLabel(Personel $personel): string
    {
        $position = $personel->position?->name;

        $base = sprintf(
            '%s %s (nr %s)',
            $personel->last_name,
            $personel->first_name,
            $personel->personal_number
        );

        return $position ? "{$base} — {$position}" : $base;
    }
}

