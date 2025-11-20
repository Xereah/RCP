<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $userModel = null;

    public string $name = '';
    public string $email = '';
    public string $role_id = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->userModel),
            ],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => $this->passwordRules(),
        ];
    }

    public function setUserModel(User $userModel): void
    {
        $this->userModel = $userModel;

        if ($userModel->exists) {
            $this->name = $userModel->name;
            $this->email = $userModel->email;
            $this->role_id = (string) $userModel->role_id;
        }
    }

    public function store(): void
    {
        $payload = $this->validatedWithHashedPassword();

        $this->userModel?->create($payload);

        $this->reset();
    }

    public function update(): void
    {
        $payload = $this->validatedWithHashedPassword(allowEmptyPassword: true);

        $this->userModel?->update($payload);

        $this->reset();
    }

    private function passwordRules(): array
    {
        return $this->userModel?->exists
            ? ['nullable', 'string', 'min:12']
            : ['required', 'string', 'min:12'];
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedWithHashedPassword(bool $allowEmptyPassword = false): array
    {
        $data = $this->validate();

        if ($allowEmptyPassword && blank($data['password'])) {
            return Arr::except($data, 'password');
        }

        $data['password'] = Hash::make($data['password']);

        return $data;
    }
}
