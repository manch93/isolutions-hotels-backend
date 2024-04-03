<?php

namespace App\Livewire\Forms\Cms\Management;

use App\Models\M3uChannel;
use App\Traits\WithSaveFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormM3uSourceChannel extends Form
{
    use WithSaveFile;

    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required')]
    public $secondary_name = '';

    #[Validate('nullable|image:jpeg,png,jpg,svg|max:2048')]
    public $icon = '';

    // Get the data
    public function getDetail($id) {
        $data = M3uChannel::find($id);

        $this->id = $id;
        $this->secondary_name = $data->secondary_name ? $data->secondary_name : $data->name;
        $this->icon = $data->icon;
    }

    // Save the data
    public function save() {
        $old = M3uChannel::find($this->id);
        $save_path = M3uChannel::$FILE_PATH;

        // Save icon
        if($this->icon) {
            $this->icon = $this->saveFile($this->icon, $save_path, $save_path)['filename'];
        } else {
            $this->icon = $old->icon;
        }

        $old->update($this->all());
    }

    // Activate All
    public function activateAll($source_id) {
        M3uChannel::where('m3u_source_id', $source_id)->update(['active' => 1]);
    }

    // Deactivate All
    public function deactivateAll($source_id) {
        M3uChannel::where('m3u_source_id', $source_id)->update(['active' => 0]);
    }

    // Activate Channel
    public function activateChannel($id) {
        M3uChannel::find($id)->update(['active' => 1]);
    }

    // Deactivate Channel
    public function deactivateChannel($id) {
        M3uChannel::find($id)->update(['active' => 0]);
    }
}
