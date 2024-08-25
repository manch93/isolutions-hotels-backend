<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormFood;
use App\Models\Food as ModelsFood;
use App\Models\FoodCategory;
use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class Food extends BaseComponent
{
    use WithFileUploads;

    public FormFood $form;
    public $title = 'Hotel Food';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Category',
                'field' => 'food_categories.name',
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
    public $foodCategories = [];
    public $trix_description;

    public function mount() {
        $this->hotels = Hotel::all();

        if(!auth()->user()->hasRole('admin')) {
            $this->foodCategories = FoodCategory::where('hotel_id', $this->hotel_id)->get();
        }
    }

    public function render()
    {
        $model = ModelsFood::join('hotels', 'hotels.id', '=', 'foods.hotel_id')
            ->join('food_categories', 'food_categories.id', '=', 'foods.food_category_id')
            ->select('foods.*', 'food_categories.name as food_category', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole('admin')) {
            $model = $model->where('foods.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.hotel.food', compact('get'))->title($this->title);
    }

    public function customEdit($id) {
        $this->edit($id);
        $this->getFoodCategory();
        $this->dispatch('setValueById', id: 'food_category', value: $this->form->food_category_id);
        $this->trix_description = $this->form->description;
    }

    public function getFoodCategory() {
        $this->foodCategories = FoodCategory::where('hotel_id', $this->form->hotel_id)->get();
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
