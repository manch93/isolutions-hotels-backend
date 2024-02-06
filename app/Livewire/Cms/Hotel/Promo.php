<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormPromo;
use App\Models\Promo as ModelsPromo;
use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class Promo extends BaseComponent
{
    use WithFileUploads;

    public FormPromo $form;
    public $title = 'Hotel Promo';

    #[Validate('nullable|image:jpeg,png,jpg,svg|max:2048')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'promos.name',
            ],
            [
                'name' => 'Description',
                'field' => 'promos.description',
            ],
            [
                'name' => 'Image',
                'field' => 'promos.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'promos.name',
        $order = 'asc';

    public $hotels = [];

    public function mount() {
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = ModelsPromo::join('hotels', 'hotels.id', '=', 'promos.hotel_id')
            ->select('promos.*', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole('admin')) {
            $model = $model->where('promos.hotel_id', $this->hotel_id);
        }

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.hotel.promo', compact('get'))->title($this->title);
    }

    public function saveWithUpload() {
        $this->form->image = $this->image;
        $this->image = null;
        $this->save();
    }
}
