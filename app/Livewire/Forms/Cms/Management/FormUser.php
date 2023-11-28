<?php

namespace App\Livewire\Forms\Cms\Management;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormUser extends Form
{
    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required')]
    public $name = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    // Get the data
    public function getDetail($id) {
        $data = User::find($id);

        $this->id = $id;
        $this->name = $data->name;
        $this->email = $data->email;
    }

    // Save the data
    public function save() {
        $this->validate();

        if ($this->id) {
            $this->update();
        } else {
            $this->store();
        }

        $this->reset();
    }

    // Store data
    public function store() {
        $user = User::create($this->only([
            'name',
            'email',
            'password',
        ]));

        $user->assignRole('admin');
    }

    // Update data
    public function update() {
        User::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        User::find($id)->delete();
    }
}
