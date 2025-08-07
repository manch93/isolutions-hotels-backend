<?php

namespace App\Livewire\Forms\Cms\Master;

use App\Models\Content;
use App\Traits\WithSaveFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormContent extends Form
{
    use WithSaveFile;

    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required|numeric')]
    public $hotel_id;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    #[Validate('nullable|numeric')]
    public $version = 1;

    #[Validate('nullable|boolean')]
    public $is_deleted = false;

    #[Validate('nullable|boolean')]
    public $is_active = true;

    // Get the data
    public function getDetail($id) {
        $data = Content::find($id);

        $this->id = $id;
        $this->hotel_id = $data->hotel_id;
        $this->name = $data->name;
        // Get raw image name from database, not the processed URL
        $this->image = $data->getOriginal('image');
        $this->version = $data->version;
        $this->is_deleted = $data->is_deleted;
        $this->is_active = $data->is_active;
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
        $save_path = Content::$FILE_PATH;

        // Get current highest version and add 1
        $current_version = Content::max('version') ?? 0;
        
        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = '';
        }

        $this->version = $current_version + 1;
        $this->is_deleted = false;

        Content::create($this->only([
            'hotel_id',
            'name',
            'image',
            'version',
            'is_deleted',
            'is_active',
        ]));
    }

    // Update data
    public function update() {
        $old = Content::find($this->id);
        $save_path = Content::$FILE_PATH ?? 'contents';

        // Save image
        if($this->image) {
            $this->image = $this->saveFile($this->image, $save_path, $save_path)['filename'];
        } else {
            $this->image = $old->getOriginal('image');
        }

        // Get current highest version and add 1
        $current_version = Content::max('version') ?? 0;
        $this->version = $current_version + 1;
        $this->is_deleted = false;

        $old->update($this->all());
    }

    // Delete data
    public function delete($id) {
        $item = Content::find($id);
        
        // Get current highest version and add 1
        $current_version = Content::max('version') ?? 0;
        
        $item->update([
            'version' => $current_version + 1,
            'is_deleted' => true
        ]);
    }
}
