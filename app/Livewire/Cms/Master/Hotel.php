<?php

namespace App\Livewire\Cms\Master;

use App\Livewire\Forms\Cms\Master\FormHotel;
use App\Models\Hotel as ModelsHotel;
use BaseComponent;

class Hotel extends BaseComponent
{
    public FormHotel $form;
    public $title = 'Hotel';

    public $searchBy = [
            [
                'name' => 'Name',
                'field' => 'name',
            ],
            [
                'name' => 'Branch',
                'field' => 'branch',
            ],
            [
                'name' => 'Address',
                'field' => 'address',
            ],
            [
                'name' => 'Phone',
                'field' => 'phone',
            ],
            [
                'name' => 'Email',
                'field' => 'email',
            ],
            [
                'name' => 'Website',
                'field' => 'website',
            ],
            [
                'name' => 'Default greeting',
                'field' => 'default_greeting',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'name',
        $order = 'asc';

    public function render()
    {
        $get = $this->getDataWithFilter(new ModelsHotel, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.master.hotel', compact('get'))->title($this->title);
    }
}
