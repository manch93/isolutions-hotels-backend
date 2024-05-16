<?php

namespace App\Livewire\Forms\Cms\Hospital;

use App\Models\Doctor;
use App\Traits\WithSaveFile;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormDoctor extends Form
{
    use WithSaveFile;

    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required|numeric')]
    public $hotel_id;

    #[Validate('required|numeric')]
    public $doctor_category_id;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string')]
    public $description;

    #[Validate('required|string')]
    public $slug;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    // Get the data
    public function getDetail($id) {
        $data = Doctor::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->doctor_category_id = $data->doctor_category_id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->slug = $data->slug;
        $this->image = $data->image;
    }

    // Save the data
    public function save() {
        $this->slug = Str::slug($this->name, '-');

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
        $save_path = Doctor::$FILE_PATH;

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = '';
        }

        Doctor::create($this->only([
            'hotel_id',
            'doctor_category_id',
            'name',
            'description',
            'slug',
            'image',
        ]));
    }

    // Update data
    public function update() {
        $old = Doctor::find($this->id);
        $save_path = Doctor::$FILE_PATH;

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = $old->image;
        }

        $old->update($this->all());
    }

    // Delete data
    public function delete($id) {
        Doctor::find($id)->delete();
    }
}
