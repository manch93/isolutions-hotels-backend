<?php

namespace App\Livewire\Forms\Cms\Hotel;

use App\Models\HotelChannelEnabled;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormEnabledChannel extends Form
{
    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required')]
    public $hotel_id = '';

    #[Validate('required')]
    public $m3u_channel_id = '';

    #[Validate('nullable')]
    public $alternative_name = '';

    #[Validate('required')]
    public $active = '';

    // Get the data
    public function getDetail($id) {
        $data = HotelChannelEnabled::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->m3u_channel_id = $data->m3u_channel_id;
        $this->alternative_name = $data->alternative_name;
        $this->active = $data->active;
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
        HotelChannelEnabled::create($this->only([
            'hotel_id',
            'm3u_channel_id',
            'alternative_name',
            'active',
        ]));
    }

    // Update data
    public function update() {
        HotelChannelEnabled::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        HotelChannelEnabled::find($id)->delete();
    }

    // Activate Channel
    public function activateChannel($id) {
        HotelChannelEnabled::find($id)->update(['active' => 1]);
    }

    // Deactivate Channel
    public function deactivateChannel($id) {
        HotelChannelEnabled::find($id)->update(['active' => 0]);
    }

    // Activate All
    public function activateAll($hotel) {
        HotelChannelEnabled::where('hotel_id', $hotel)->update(['active' => 1]);
    }

    // Deactivate All
    public function deactivateAll($hotel) {
        HotelChannelEnabled::where('hotel_id', $hotel)->update(['active' => 0]);
    }
}
