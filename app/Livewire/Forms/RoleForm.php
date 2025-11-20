<?php

namespace App\Livewire\Forms;

use App\Models\Role;
use Livewire\Form;

class RoleForm extends Form
{
    public ?Role $roleModel;
    
    public $name = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
        ];
    }

    public function setRoleModel(Role $roleModel): void
    {
        $this->roleModel = $roleModel;
        
        $this->name = $this->roleModel->name;
    }

    public function store(): void
    {
        $this->roleModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->roleModel->update($this->validate());

        $this->reset();
    }
}
