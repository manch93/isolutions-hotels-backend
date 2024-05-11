<?php

namespace App\Livewire\Forms\Cms\Hotel;

use App\Models\Wifi;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormWifi extends Form
{
    #[Validate('nullable|numeric')]
    public $id;

    #[Validate('required|numeric')]
    public $hotel_id;

    #[Validate('required|string')]
    public $security_type;

    #[Validate('required|string')]
    public $ssid_name;

    #[Validate('required|string')]
    public $ssid_password;

    // Get the data
    public function getDetail($id) {
        $data = Wifi::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->security_type = $data->security_type;
        $this->ssid_name = $data->ssid_name;
        $this->ssid_password = $data->ssid_password;
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
        Wifi::create($this->only([
            'hotel_id',
            'security_type',
            'ssid_name',
            'ssid_password',
        ]));
    }

    // Update data
    public function update() {
        Wifi::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        Wifi::find($id)->delete();
    }
}
