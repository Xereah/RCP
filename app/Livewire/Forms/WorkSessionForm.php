<?php

namespace App\Livewire\Forms;

use App\Models\WorkSession;
use Livewire\Form;

class WorkSessionForm extends Form
{
    public ?WorkSession $workSessionModel;
    
    public $personel_id = '';
    public $work_date = '';
    public $start_time = '';
    public $end_time = '';
    public $duration = '';
    public $notes = '';
    public $status_id = '';

    public function rules(): array
    {
        return [
			'personel_id' => 'required',
			'notes' => 'string',
			'status_id' => 'required',
        ];
    }

    public function setWorkSessionModel(WorkSession $workSessionModel): void
    {
        $this->workSessionModel = $workSessionModel;
        
        $this->personel_id = $this->workSessionModel->personel_id;
        $this->work_date = $this->workSessionModel->work_date;
        $this->start_time = $this->workSessionModel->start_time;
        $this->end_time = $this->workSessionModel->end_time;
        $this->duration = $this->workSessionModel->duration;
        $this->notes = $this->workSessionModel->notes;
        $this->status_id = $this->workSessionModel->status_id;
    }

    public function store(): void
    {
        $this->workSessionModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->workSessionModel->update($this->validate());

        $this->reset();
    }
}
