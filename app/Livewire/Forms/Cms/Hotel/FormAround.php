<?php

namespace App\Livewire\Forms\Cms\Hotel;

use App\Models\Around;
use App\Traits\WithSaveFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormAround extends Form
{
    use WithSaveFile;

    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required|numeric')]
    public $hotel_id;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string')]
    public $description;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    // Get the data
    public function getDetail($id) {
        $data = Around::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->image = $data->image;
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
        $save_path = Around::$FILE_PATH;

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = '';
        }

        Around::create($this->only([
            'hotel_id',
            'name',
            'description',
            'image',
        ]));
    }

    // Update data
    public function update() {
        $old = Around::find($this->id);
        $save_path = Around::$FILE_PATH;

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
        Around::find($id)->delete();
    }
}
