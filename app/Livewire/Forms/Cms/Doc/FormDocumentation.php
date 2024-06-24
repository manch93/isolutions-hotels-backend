<?php

namespace App\Livewire\Forms\Cms\Doc;

use App\Models\Documentation;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormDocumentation extends Form
{
    #[Validate('nullable|numeric')]
    public $id = '';

    #[Validate('required')]
    public $menu_id = '';

    #[Validate('required')]
    public $title = '';

    #[Validate('required')]
    public $description = '';

    // Get the data
    public function getDetail($id) {
        $data = Documentation::find($id);

        $this->id = $id;
        $this->menu_id = $data->menu_id;
        $this->title = $data->title;
        $this->description = $data->description;
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
        Documentation::create($this->only([
            'menu_id',
            'title',
            'description',
        ]));
    }

    // Update data
    public function update() {
        Documentation::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        Documentation::find($id)->delete();
    }
}
