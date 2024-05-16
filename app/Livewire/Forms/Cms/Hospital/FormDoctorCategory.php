<?php

namespace App\Livewire\Forms\Cms\Hospital;

use App\Models\DoctorCategory;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormDoctorCategory extends Form
{
    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required|numeric')]
    public $hotel_id;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string')]
    public $description;

    // Get the data
    public function getDetail($id) {
        $data = DoctorCategory::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->name = $data->name;
        $this->description = $data->description;
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
        DoctorCategory::create($this->only([
            'hotel_id',
            'name',
            'description',
        ]));
    }

    // Update data
    public function update() {
        DoctorCategory::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        DoctorCategory::find($id)->delete();
    }
}
