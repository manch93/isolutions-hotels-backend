<?php

namespace App\Traits;

trait WithCreateAction {
    public function create() {
        $this->imageIttr++;
        $this->isUpdate = false;

        if(isset($this->trix_description)) {
            $this->trix_description = null;
        }

        $this->form->reset();
    }
}
