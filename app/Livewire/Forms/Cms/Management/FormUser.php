<?php

namespace App\Livewire\Forms\Cms\Management;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FormUser extends Form
{
    #[Rule('nullable|numeric')]
    public $id = '';

    #[Rule('required')]
    public $name = '';

    #[Rule('required|email')]
    public $email = '';

    #[Rule('required')]
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
