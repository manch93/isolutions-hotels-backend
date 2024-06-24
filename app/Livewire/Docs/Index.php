<?php

namespace App\Livewire\Docs;

use App\Models\Menu;
use App\Models\Documentation;
use BaseComponent;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.docs')]
class Index extends BaseComponent
{
    public $title = '';
    public $documentation;

    public function mount($slug = null) {
        $slug = $slug == null ? '/' : '/' . $slug;

        // Check url exists
        $menu = Menu::where('route', $slug)->first();

        if ($menu) {
            $this->documentation = Documentation::where('menu_id', $menu->id)->first();
        }
    }

    public function render()
    {
        return view('livewire.docs.index');
    }
}
