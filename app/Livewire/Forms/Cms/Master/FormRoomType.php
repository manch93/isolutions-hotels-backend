<?php

namespace App\Livewire\Forms\Cms\Master;

use App\Models\RoomType;
use App\Traits\WithSaveFile;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FormRoomType extends Form
{
    use WithSaveFile;

    #[Rule('nullable|numeric')]
    public $id = '';

    #[Rule('required|numeric')]
    public $hotel_id;

    #[Rule('required|string')]
    public $name = '';

    #[Rule('required|string')]
    public $description;

    #[Rule('nullable|image:jpeg,png,jpg,svg|max:2048')]
    public $image;

    // Get the data
    public function getDetail($id) {
        $data = RoomType::find($id);

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
        $save_path = 'room_type';

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = '';
        }

        RoomType::create($this->only([
            'hotel_id',
            'name',
            'description',
            'image',
        ]));
    }

    // Update data
    public function update() {
        $old = RoomType::find($this->id);
        $save_path = 'room_type';

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
        RoomType::find($id)->delete();
    }
}
