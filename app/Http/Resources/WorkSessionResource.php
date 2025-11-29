<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'work_date' => $this->work_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'duration' => $this->duration,
            'adjusted_duration' => $this->getAdjustedDuration(),
            'duration_human' => $this->duration_human,
            'notes' => $this->notes,
            'has_overtime' => $this->has_overtime,
            'incomplete_shift_warning' => $this->incomplete_shift_warning,
            'display_status' => $this->display_status,
            'personel' => [
                'id' => $this->personel->id,
                'personal_number' => $this->personel->personal_number,
                'first_name' => $this->personel->first_name,
                'last_name' => $this->personel->last_name,
                'full_name' => $this->personel->first_name . ' ' . $this->personel->last_name,
                'email' => $this->personel->email,
                'is_active' => $this->personel->is_active,
                'position' => [
                    'id' => $this->personel->position->id ?? null,
                    'name' => $this->personel->position->name ?? null,
                ],
                'work_place' => [
                    'id' => $this->personel->workPlace->id ?? null,
                    'name' => $this->personel->workPlace->name ?? null,
                ],
            ],
            'status' => [
                'id' => $this->workStatus->id ?? null,
                'name' => $this->workStatus->name ?? null,
            ],
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}

