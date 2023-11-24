<?php

namespace App\Traits;

use App\Enums\Alert;

trait WithSaveAction {
    public function save() {
        $this->form->save();

        $this->dispatch('closeModal', modal: 'acc-modal');
        $this->dispatch('alert', type: Alert::success, message: $this->isUpdate ? 'Data Updated' : 'Data Created');
    }
}
