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

class BaseComponent extends Component {
    use WithPagination,
        WithChangeOrder,
        WithGetFilterData,
        WithCreateAction,
        WithEditAction,
        WithDeleteAction,
        WithSaveAction;

    public $originRoute = '';
    public $hotel_id = '';

    public function __construct()
    {
        $this->originRoute = request()->route()->getName();
        $this->hotel_id = auth()->user()->userHotel?->hotel_id;
    }
}
