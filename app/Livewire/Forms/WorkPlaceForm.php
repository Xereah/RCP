<?php

namespace App\Livewire\Forms;

use App\Models\WorkPlace;
use Livewire\Form;

class WorkPlaceForm extends Form
{
    public ?WorkPlace $workPlaceModel;
    
    public $name = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
        ];
    }

    public function setWorkPlaceModel(WorkPlace $workPlaceModel): void
    {
        $this->workPlaceModel = $workPlaceModel;
        
        $this->name = $this->workPlaceModel->name;
    }

    public function store(): void
    {
        $this->workPlaceModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->workPlaceModel->update($this->validate());

        $this->reset();
    }
}
