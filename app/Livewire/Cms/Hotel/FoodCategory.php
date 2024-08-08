<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormFoodCategory;
use App\Models\FoodCategory as ModelsFoodCategory;
use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class FoodCategory extends BaseComponent
{
    use WithFileUploads;

    public FormFoodCategory $form;
    public $title = 'Hotel Food Category';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'food_categories.name',
            ],
            [
                'name' => 'Description',
                'field' => 'food_categories.description',
            ],
            [
                'name' => 'Image',
                'field' => 'food_categories.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'food_categories.name',
        $order = 'asc';

    public $hotels = [];
    public $trix_description;

    public function mount() {
        $this->isModalOpen = true;
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = ModelsFoodCategory::join('hotels', 'hotels.id', '=', 'food_categories.hotel_id')
            ->select('food_categories.*', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole('admin')) {
            $model = $model->where('food_categories.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.hotel.food-category', compact('get'))->title($this->title);
    }

    public function customEdit($id) {
        $this->edit($id);
        $this->trix_description = $this->form->description;
    }

    public function saveWithUpload() {
        if($this->hotel_id) {
            $this->form->hotel_id = $this->hotel_id;
        }
        $this->form->description = $this->trix_description;
        $this->form->image = $this->image;
        $this->save();
        $this->image = null;
        $this->trix_description = null;
    }
}
