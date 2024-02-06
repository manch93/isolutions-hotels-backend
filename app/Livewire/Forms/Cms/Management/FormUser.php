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
    public $role = '';

    #[Validate('required')]
    public $name = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    #[Validate('nullable|numeric')]
    public $hotel = '';

    // Get the data
    public function getDetail($id) {
        $data = User::with('userHotel')->find($id);

        $this->id = $id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->role = $data->getRoleNames()[0];
        $this->hotel = $data->userHotel?->hotel_id;
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

        // Assign new role
        $user->assignRole($this->role);
        // Assign new hotel
        $user->userHotel()->create([
            'user_id' => $user->id,
            'hotel_id' => $this->hotel,
        ]);
    }

    // Update data
    public function update() {
        $user = User::find($this->id);

        // Remove all role
        $user->syncRoles([]);

        // Assign new role
        $user->assignRole($this->role);

        // Assign new hotel
        $user->userHotel()->delete();
        $user->userHotel()->create([
            'user_id' => $user->id,
            'hotel_id' => $this->hotel,
        ]);
        $user->update([
            'name',
            'email',
            'password',
        ]);
    }

    // Delete data
    public function delete($id) {
        User::find($id)->delete();
    }
}
