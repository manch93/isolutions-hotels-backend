<?php

namespace App\Livewire\Forms\Cms\Hotel;

use App\Models\Event;
use App\Traits\WithSaveFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormEvent extends Form
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
        $data = Event::find($id);

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
        $save_path = Event::$FILE_PATH;

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = '';
        }

        Event::create($this->only([
            'hotel_id',
            'name',
            'description',
            'image',
        ]));
    }

    // Update data
    public function update() {
        $old = Event::find($this->id);
        $save_path = Event::$FILE_PATH;

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
        Event::find($id)->delete();
    }
}
