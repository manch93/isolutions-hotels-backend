<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormPolicy;
use App\Models\Hotel;
use App\Models\Policy as ModelsPolicy;
use BaseComponent;

class Policy extends BaseComponent
{
    public FormPolicy $form;
    public $title = 'Hotel Policy';

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'policies.name',
            ],
            [
                'name' => 'Description',
                'field' => 'policies.description',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'policies.name',
        $order = 'asc';

    public $hotels = [];
    public $trix_description;

    public function mount() {
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = ModelsPolicy::join('hotels', 'hotels.id', '=', 'policies.hotel_id')
            ->select('policies.*', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $model = $model->where('policies.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.hotel.policy', compact('get'))->title($this->title);
    }

    public function customEdit($id) {
        $this->edit($id);
        $this->trix_description = $this->form->description;
    }

    public function customSave() {
        if($this->hotel_id) {
            $this->form->hotel_id = $this->hotel_id;
        }
        $this->form->description = $this->trix_description;
        $this->save();
        $this->trix_description = null;
    }
}
