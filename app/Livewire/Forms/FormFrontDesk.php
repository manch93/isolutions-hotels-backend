<?php

namespace App\Livewire\Forms;

use App\Models\Room;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormFrontDesk extends Form
{
    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required|string')]
    public $room_type = '';

    #[Validate('required|string')]
    public $no = '';

    #[Validate('required|string')]
    public $guest_name = '';


    // Get the data
    public function getDetail($id) {
        $data = Room::with('roomType')->find($id);

        $this->id = $id;
        $this->room_type = $data->roomType->name;
        $this->no = $data->no;
        $this->guest_name = $data->guest_name;
    }

    // Check In
    public function checkIn() {
        $this->validate();

        Room::find($this->id)->update([
            'guest_name' => $this->guest_name
        ]);
    }

    // Check Out
    public function checkOut() {
        Room::find($this->id)->update([
            'guest_name' => null
        ]);
    }
}
