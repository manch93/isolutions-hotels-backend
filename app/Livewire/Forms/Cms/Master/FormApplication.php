<?php

namespace App\Livewire\Forms\Cms\Master;

use App\Models\Application;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Traits\WithSaveFile;

class FormApplication extends Form
{
    use WithSaveFile;
    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required|numeric')]
    public $hotel_id;
    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string')]
    public $package_name = '';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    #[Validate('nullable|numeric')]
    public $version = 1;

    #[Validate('nullable|boolean')]
    public $is_deleted = false;
    public function getDetail($id) {
        $data = Application::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->name = $data->name;
        $this->package_name = $data->package_name;
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
        $save_path = Application::$FILE_PATH;

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = '';
        }
        $this->version = Application::version() + 1;
        $this->is_deleted = false;

        Application::create($this->only([
            'hotel_id',
            'name',
            'package_name',
            'image',
            'version',
            'is_deleted'
        ]));
    }

    // Update data
    public function update() {
        $old = Application::find($this->id);
        $save_path = Application::$FILE_PATH;

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
        $item = Application::find($id);
        $item->update([
            'version' => $item->version() + 1,
            'is_deleted' => true
        ]);
    }
}
