<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormFacility;
use App\Models\Hotel;
use App\Models\HotelFacility;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class Facility extends BaseComponent
{
    use WithFileUploads;

    public FormFacility $form;
    public $title = 'Hotel Facility';

    #[Validate('nullable|image:jpeg,png,jpg,svg|max:2048')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'hotel_facilities.name',
            ],
            [
                'name' => 'Description',
                'field' => 'hotel_facilities.description',
            ],
            [
                'name' => 'Image',
                'field' => 'hotel_facilities.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'hotel_facilities.name',
        $order = 'asc';

    public $hotels = [];

    public function mount() {
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = HotelFacility::join('hotels', 'hotels.id', '=', 'hotel_facilities.hotel_id')
            ->select('hotel_facilities.*', 'hotels.name as hotel');

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.hotel.facility', compact('get'))->title($this->title);
    }

    public function saveWithUpload() {
        $this->form->image = $this->image;
        $this->image = null;
        $this->save();
    }
}
