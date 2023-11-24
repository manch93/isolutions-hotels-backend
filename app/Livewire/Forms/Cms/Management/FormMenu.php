<?php

namespace App\Livewire\Forms\Cms\Management;

use App\Models\Menu;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FormMenu extends Form
{
    #[Rule('nullable|numeric')]
    public $id = '';

    #[Rule('required')]
    public $name = '';

    #[Rule('required')]
    public $on = '';

    #[Rule('required')]
    public $type = '';

    #[Rule('required')]
    public $icon = '';

    #[Rule('required')]
    public $route = '';

    #[Rule('required|numeric')]
    public $ordering = 0;

    // Get the data
    public function getDetail($id) {
        $data = Menu::find($id);

        $this->id = $id;
        $this->name = $data->name;
        $this->on = $data->on;
        $this->type = $data->type;
        $this->icon = $data->icon;
        $this->route = $data->route;
        $this->ordering = $data->ordering;
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
        Menu::create($this->only([
            'name',
            'on',
            'type',
            'icon',
            'route',
            'ordering',
        ]));
    }

    // Update data
    public function update() {
        Menu::find($this->id)->update($this->all());
    }

    // Delete data
    public function delete($id) {
        Menu::find($id)->delete();
    }
}
