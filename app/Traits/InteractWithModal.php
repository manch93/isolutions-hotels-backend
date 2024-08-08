<?php

namespace App\Traits;

trait InteractWithModal {
    public function openModal() {
        $this->isModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
    }
}
