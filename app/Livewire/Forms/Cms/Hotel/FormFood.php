<?php

namespace App\Livewire\Forms\Cms\Hotel;

use App\Models\Food;
use App\Traits\WithSaveFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormFood extends Form
{
    use WithSaveFile;

    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required|numeric')]
    public $hotel_id;

    #[Validate('required|numeric')]
    public $food_category_id;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string')]
    public $description;

    #[Validate('required|numeric')]
    public $price;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    #[Validate('nullable|numeric')]
    public $version = 1;

    #[Validate('nullable|boolean')]
    public $is_deleted = false;
    // Get the data
    public function getDetail($id) {
        $data = Food::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->food_category_id = $data->food_category_id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->price = $data->price;
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
        $save_path = Food::$FILE_PATH;

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = '';
        }
        $this->version = Food::version() + 1;
        $this->is_deleted = false;

        Food::create($this->only([
            'hotel_id',
            'food_category_id',
            'name',
            'description',
            'image',
            'price',
            'version',
            'is_deleted'
        ]));
    }

    // Update data
    public function update() {
        $old = Food::find($this->id);
        $save_path = Food::$FILE_PATH;

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = $old->image;
        }

        // Increment version
        $this->version = $old->version() + 1;
        $this->is_deleted = false;

        $old->update($this->all());
    }

    // Delete data
    public function delete($id) {
        $item = Food::find($id);
        $item->update([
            'version' => $item->version() + 1,
            'is_deleted' => true
        ]);
    }
}
