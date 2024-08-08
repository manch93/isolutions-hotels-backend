<?php

namespace App\Livewire;

use App\Traits\WithChangeOrder;
use App\Traits\WithGetFilterData;
use Livewire\WithPagination;
use Livewire\Component;
use App\Traits\WithCreateAction;
use App\Traits\WithDeleteAction;
use App\Traits\WithEditAction;
use App\Traits\WithSaveAction;
use App\Traits\InteractWithModal;
use App\Traits\WithResetAction;

class BaseComponent extends Component {
    use WithPagination,
        WithChangeOrder,
        WithGetFilterData,
        WithCreateAction,
        WithEditAction,
        WithDeleteAction,
        WithSaveAction,
        WithResetAction,
        InteractWithModal;

    public $originRoute = '';
    public $hotel_id = '';

    // Image iterator for image set null after save
    public $imageIttr = 1;

     // Modal
    public $isModalOpen = false;

    public function __construct()
    {
        $this->originRoute = request()->route()->getName();
        $this->hotel_id = auth()->user()->userHotel?->hotel_id;
    }
}
