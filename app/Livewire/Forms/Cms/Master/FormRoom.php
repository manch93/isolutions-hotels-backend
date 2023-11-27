<?php

namespace App\Livewire\Forms\Cms\Master;

use App\Models\Room;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FormRoom extends Form
{
    #[Rule('nullable|numeric')]
    public $id = '';

    #[Rule('required|numeric')]
    public $hotel_id;

    #[Rule('required|numeric')]
    public $room_type_id;

    #[Rule('required|string')]
    public $no = '';

    #[Rule('required|string')]
    public $greeting;

    #[Rule('required|string')]
    public $device_name;

    // Get the data
    public function getDetail($id) {
        $data = Room::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->room_type_id = $data->room_type_id;
        $this->no = $data->no;
        $this->greeting = $data->greeting;
        $this->device_name = $data->device_name;
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
        Room::create($this->only([
            'hotel_id',
            'room_type_id',
            'no',
            'greeting',
            'device_name',
        ]));
    }

    // Update data
    public function update() {
        Room::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        Room::find($id)->delete();
    }
}
