<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormFood;
use App\Models\Food as ModelsFood;
use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class Food extends BaseComponent
{
    use WithFileUploads;

    public FormFood $form;
    public $title = 'Hotel Food';

    #[Validate('nullable|image:jpeg,png,jpg,svg|max:2048')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'foods.name',
            ],
            [
                'name' => 'Price',
                'field' => 'foods.price',
            ],
            [
                'name' => 'Description',
                'field' => 'foods.description',
            ],
            [
                'name' => 'Image',
                'field' => 'foods.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'foods.name',
        $order = 'asc';

    public $hotels = [];

    public function mount() {
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = ModelsFood::join('hotels', 'hotels.id', '=', 'foods.hotel_id')
            ->select('foods.*', 'hotels.name as hotel');

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.hotel.food', compact('get'))->title($this->title);
    }

    public function saveWithUpload() {
        $this->form->image = $this->image;
        $this->image = null;
        $this->save();
    }
}
