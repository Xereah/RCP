<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Edit extends Component
{
    public UserForm $form;

    /** @var array<int, string> */
    public array $roles = [];

    public function mount(User $user): void
    {
        $this->form->setUserModel($user);
        $this->roles = Role::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function save(): void
    {
        $this->form->update();

        $this->redirectRoute('users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.edit', [
            'roles' => $this->roles,
        ]);
    }
}
