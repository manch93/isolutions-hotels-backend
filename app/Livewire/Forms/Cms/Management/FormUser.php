<?php

namespace App\Livewire\Forms\Cms\Management;

use App\Models\User;
use Livewire\Form;

class FormUser extends Form
{
    public $id;

    public $created_by;

    public $role;

    public $name;

    public $email;

    public $password;

    public $hotel;

    // Get the data
    public function getDetail($id) {
        $data = User::with('userHotel')->find($id);

        $this->id = $id;
        $this->created_by = $data->created_by;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->role = $data->getRoleNames()[0];
        $this->hotel = $data->userHotel?->hotel_id;
    }

    // Save the data
    public function save() {
        if ($this->id) {
            $this->update();
        } else {
            $this->store();
        }

        $this->reset();
    }

    // Store data
    public function store() {
        $rules = [
            'id' => 'nullable|numeric',
            'created_by' => 'nullable|numeric',
            'role' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'hotel' => 'required|numeric',
        ];

        if(in_array($this->role, ['admin', 'admin_reseller'])) {
            $rules['hotel'] = 'nullable|numeric';
        }

        $this->created_by = auth()->user()->id;

        $this->validate($rules);

        $user = User::create($this->only([
            'created_by',
            'name',
            'email',
            'password',
        ]));

        // Assign new role
        $user->assignRole($this->role);

        if(!in_array($this->role, ['admin', 'admin_reseller'])) {
            // Assign new hotel
            $user->userHotel()->create([
                'user_id' => $user->id,
                'hotel_id' => $this->hotel,
            ]);
        }
    }

    // Update data
    public function update() {
        $rules = [
            'id' => 'nullable|numeric',
            'created_by' => 'nullable|numeric',
            'role' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'hotel' => 'required|numeric',
        ];

        if(in_array($this->role, ['admin', 'admin_reseller'])) {
            $rules['hotel'] = 'nullable|numeric';
        }

        $this->validate($rules);

        $user = User::find($this->id);

        // Remove all role
        $user->syncRoles([]);

        // Assign new role
        $user->assignRole($this->role);

        if(!in_array($this->role, ['admin', 'admin_reseller'])) {
            // Assign new hotel
            $user->userHotel()->delete();
            $user->userHotel()->create([
                'user_id' => $user->id,
                'hotel_id' => $this->hotel,
            ]);
        }

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
