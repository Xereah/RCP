<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\WorkSession;
use Illuminate\Support\Carbon;
use Livewire\Form;

class WorkSessionForm extends Form
{
    public ?WorkSession $workSessionModel = null;

    public ?int $personel_id = null;
    public ?string $work_date = null;
    public ?string $start_time = null;
    public ?string $end_time = null;
    public ?string $duration = null;
    public ?string $notes = null;
    public ?int $status_id = null;

    public function rules(): array
    {
        return [
            'personel_id' => ['required', 'integer', 'exists:personel,id'],
            'work_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'notes' => ['nullable', 'string'],
            'status_id' => ['required', 'integer', 'exists:work_statuses,id'],
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
        $this->workSessionModel->create($this->buildPayload());

        $this->reset();
    }

    public function update(): void
    {
        $this->workSessionModel->update($this->buildPayload());

        $this->reset();
    }

    protected function buildPayload(): array
    {
        $data = $this->validate();

        $data['duration'] = $this->calculateDurationMinutes(
            $data['work_date'],
            $data['start_time'],
            $data['end_time'] ?? null
        );

        return $data;
    }

    protected function calculateDurationMinutes(string $date, string $start, ?string $end): ?int
    {
        if (blank($end)) {
            return null;
        }

        $startDateTime = Carbon::parse("{$date} {$start}");
        $endDateTime = Carbon::parse("{$date} {$end}");

        if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
            $endDateTime->addDay();
        }

        return (int) $startDateTime->diffInMinutes($endDateTime);
    }
}
