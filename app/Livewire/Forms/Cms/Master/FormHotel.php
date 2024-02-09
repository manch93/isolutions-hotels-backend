<?php

namespace App\Livewire\Forms\Cms\Master;

use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormHotel extends Form
{
    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string')]
    public $branch;

    #[Validate('required|string')]
    public $address;

    #[Validate('required|numeric')]
    public $phone;

    #[Validate('required|string|email')]
    public $email;

    #[Validate('required|string')]
    public $website;

    #[Validate('nullable|string')]
    public $default_greeting;

    #[Validate('required|string')]
    public $password_setting;

    #[Validate('required|boolean')]
    public $is_active;

    // Get the data
    public function getDetail($id) {
        $data = Hotel::find($id);

        $this->id = $id;
        $this->name = $data->name;
        $this->branch = $data->branch;
        $this->address = $data->address;
        $this->phone = $data->phone;
        $this->email = $data->email;
        $this->website = $data->website;
        $this->default_greeting = $data->default_greeting;
        $this->password_setting = $data->password_setting;
        $this->is_active = $data->is_active;
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
        Hotel::create($this->only([
            'name',
            'branch',
            'address',
            'phone',
            'email',
            'website',
            'default_greeting',
            'password_setting',
            'is_active',
        ]));
    }

    // Update data
    public function update() {
        Hotel::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        Hotel::find($id)->delete();
    }
}
