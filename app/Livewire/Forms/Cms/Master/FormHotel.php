<?php

namespace App\Livewire\Forms\Cms\Master;

use App\Models\Hotel;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FormHotel extends Form
{
    #[Rule('nullable|numeric')]
    public $id = '';

    #[Rule('required|string')]
    public $name = '';

    #[Rule('required|string')]
    public $branch;

    #[Rule('required|string')]
    public $address;

    #[Rule('required|numeric')]
    public $phone;

    #[Rule('required|string|email')]
    public $email;

    #[Rule('required|string')]
    public $website;

    #[Rule('nullable|string')]
    public $default_greeting;

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
