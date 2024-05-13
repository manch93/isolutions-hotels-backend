<?php

namespace App\Traits;

trait WithEditAction {
    public function edit($id) {
        $this->imageIttr++;
        $this->isUpdate = true;
        $this->form->getDetail($id);
    }
}
