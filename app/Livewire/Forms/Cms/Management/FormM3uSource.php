<?php

namespace App\Livewire\Forms\Cms\Management;

use App\Models\M3uSource;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormM3uSource extends Form
{
    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $url = '';

    #[Validate('required')]
    public $type = '';

    #[Validate('nullable')]
    public $headers = '';

    #[Validate('nullable')]
    public $body = '';

    #[Validate('required|numeric')]
    public $active;

    // Get the data
    public function getDetail($id) {
        $data = M3uSource::find($id);

        $this->id = $id;
        $this->name = $data->name;
        $this->url = $data->url;
        $this->type = $data->type;
        $this->headers = $data->headers;
        $this->body = $data->body;
        $this->active = $data->active;
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
        M3uSource::create($this->only([
            'name',
            'url',
            'type',
            'headers',
            'body',
            'active',
        ]));
    }

    // Update data
    public function update() {
        M3uSource::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        M3uSource::find($id)->delete();
    }
}
