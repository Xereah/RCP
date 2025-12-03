<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\WorkTimeRegulation;
use Livewire\Form;

class WorkTimeRegulationForm extends Form
{
    public ?WorkTimeRegulation $workTimeRegulationModel;
    
    public string $name = '';
    public string $code = '';
    public string $description = '';
    public string $daily_hours = '8.00';
    public string $weekly_hours = '40.00';
    public string $monthly_hours = '';
    public bool $is_task_based = false;
    public string $break_minutes = '15';
    public string $nursing_mother_break = '0';
    public string $start_time_flex = '0';
    public string $end_time_flex = '0';
    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:work_time_regulations,code,' . ($this->workTimeRegulationModel->id ?? 'NULL'),
            'description' => 'nullable|string',
            'daily_hours' => 'required|numeric|min:0|max:24',
            'weekly_hours' => 'required|numeric|min:0|max:168',
            'monthly_hours' => 'nullable|numeric|min:0',
            'is_task_based' => 'boolean',
            'break_minutes' => 'required|integer|min:0',
            'nursing_mother_break' => 'required|integer|min:0',
            'start_time_flex' => 'required|integer|min:0',
            'end_time_flex' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function setWorkTimeRegulationModel(?WorkTimeRegulation $workTimeRegulationModel = null): void
    {
        $this->workTimeRegulationModel = $workTimeRegulationModel ?? new WorkTimeRegulation();
        
        $this->name = $this->workTimeRegulationModel->name ?? '';
        $this->code = $this->workTimeRegulationModel->code ?? '';
        $this->description = $this->workTimeRegulationModel->description ?? '';
        $this->daily_hours = $this->workTimeRegulationModel->daily_hours ?? '8.00';
        $this->weekly_hours = $this->workTimeRegulationModel->weekly_hours ?? '40.00';
        $this->monthly_hours = $this->workTimeRegulationModel->monthly_hours ?? '';
        $this->is_task_based = $this->workTimeRegulationModel->is_task_based ?? false;
        $this->break_minutes = (string) ($this->workTimeRegulationModel->break_minutes ?? 15);
        $this->nursing_mother_break = (string) ($this->workTimeRegulationModel->nursing_mother_break ?? 0);
        $this->start_time_flex = (string) ($this->workTimeRegulationModel->start_time_flex ?? 0);
        $this->end_time_flex = (string) ($this->workTimeRegulationModel->end_time_flex ?? 0);
        $this->is_active = $this->workTimeRegulationModel->is_active ?? true;
    }

    public function store(): void
    {
        $validated = $this->validate();
        
        // Konwertuj puste wartości na null dla pól numerycznych
        if (empty($validated['monthly_hours'])) {
            $validated['monthly_hours'] = null;
        }
        
        WorkTimeRegulation::query()->create($validated);

        $this->reset();
    }

    public function update(): void
    {
        $validated = $this->validate();
        
        // Konwertuj puste wartości na null dla pól numerycznych
        if (empty($validated['monthly_hours'])) {
            $validated['monthly_hours'] = null;
        }
        
        $this->workTimeRegulationModel->update($validated);

        $this->reset();
    }
}

