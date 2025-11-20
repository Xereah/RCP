<?php
declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Position;
use Livewire\Form;

class PositionForm extends Form
{
    public ?Position $positionModel;
    public string $name = '';

    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function setPositionModel(?Position $positionModel = null): void
    {
        $this->positionModel = $positionModel ?? new Position();
        $this->name = $this->positionModel->name ?? '';
    }

    public function store(): void
    {
        Position::query()->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->positionModel->update($this->validate());

        $this->reset();
    }
}
