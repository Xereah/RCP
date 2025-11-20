<?php

namespace App\Livewire\Forms;

use App\Models\WorkStatus;
use Livewire\Form;

class WorkStatusForm extends Form
{
    public ?WorkStatus $workStatusModel;
    
    public $name = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
        ];
    }

    public function setWorkStatusModel(WorkStatus $workStatusModel): void
    {
        $this->workStatusModel = $workStatusModel;
        
        $this->name = $this->workStatusModel->name;
    }

    public function store(): void
    {
        $this->workStatusModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->workStatusModel->update($this->validate());

        $this->reset();
    }
}
