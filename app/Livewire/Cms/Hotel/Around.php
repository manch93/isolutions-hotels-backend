<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormAround;
use App\Models\Around as ModelsAround;
use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class Around extends BaseComponent
{
    use WithFileUploads;

    public FormAround $form;
    public $title = 'Hotel Around';

    #[Validate('nullable|image:jpeg,png,jpg,svg|max:2048')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'arounds.name',
            ],
            [
                'name' => 'Description',
                'field' => 'arounds.description',
            ],
            [
                'name' => 'Image',
                'field' => 'arounds.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'arounds.name',
        $order = 'asc';

    public $hotels = [];
    public $trix_description;

    public function mount() {
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = ModelsAround::join('hotels', 'hotels.id', '=', 'arounds.hotel_id')
            ->select('arounds.*', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole('admin')) {
            $model = $model->where('arounds.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.hotel.around', compact('get'))->title($this->title);
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
        $this->image = null;
        $this->save();
    }
}
