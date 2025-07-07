<?php

namespace App\Livewire\Forms\Cms\Hotel;

use App\Models\FoodCategory;
use App\Traits\WithSaveFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormFoodCategory extends Form
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

    #[Validate('nullable|numeric')]
    public $version = 1;

    #[Validate('nullable|boolean')]
    public $is_deleted = false;

    // Get the data
    public function getDetail($id) {
        $data = FoodCategory::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->image = $data->image;
        $this->version = $data->version;
        $this->is_deleted = $data->is_deleted;
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
        $save_path = FoodCategory::$FILE_PATH;

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = '';
        }

        $this->version = FoodCategory::version() + 1;
        $this->is_deleted = false;

        FoodCategory::create($this->only([
            'hotel_id',
            'name',
            'description',
            'image',
        ]));
    }

    // Update data
    public function update() {
        $old = FoodCategory::find($this->id);
        $save_path = FoodCategory::$FILE_PATH;

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
        $item = FoodCategory::find($id);
        $item->update([
            'version' => $item->version() + 1,
            'is_deleted' => true
        ]);
    }
}
