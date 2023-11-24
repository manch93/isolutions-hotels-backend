<?php

namespace App\Traits;

use App\Enums\Alert;
use Livewire\Attributes\On;

trait WithDeleteAction {
    public function confirmDelete($id) {
        $this->dispatch('confirm', function: 'delete', id: $id);
    }

    #[On('delete')]
    public function delete($id) {
        $this->form->delete($id);

        $this->dispatch('alert', type: Alert::success, message: 'Data deleted successfully');
    }
}
