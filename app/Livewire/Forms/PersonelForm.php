<?php

namespace App\Livewire\Forms;

use App\Models\Personel;
use Livewire\Form;

class PersonelForm extends Form
{
    public ?Personel $personelModel;
    
    public $personal_number = '';
    public $last_name = '';
    public $first_name = '';
    public $email = '';
    public $position_id = '';
    public $is_active = '';

    public function rules(): array
    {
        return [
			'personal_number' => 'string',
			'last_name' => 'string',
			'first_name' => 'string',
			'email' => 'string',
			'position_id' => 'required',
			'is_active' => 'required',
        ];
    }

    public function setPersonelModel(Personel $personelModel): void
    {
        $this->personelModel = $personelModel;
        
        $this->personal_number = $this->personelModel->personal_number;
        $this->last_name = $this->personelModel->last_name;
        $this->first_name = $this->personelModel->first_name;
        $this->email = $this->personelModel->email;
        $this->position_id = $this->personelModel->position_id;
        $this->is_active = $this->personelModel->is_active;
    }

    public function store(): void
    {
        $this->personelModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->personelModel->update($this->validate());

        $this->reset();
    }
}
