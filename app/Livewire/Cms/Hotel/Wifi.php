<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormWifi;
use App\Models\Hotel;
use App\Models\Wifi as ModelsWifi;
use BaseComponent;

class Wifi extends BaseComponent
{
    public FormWifi $form;
    public $title = 'Wifi';

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Security Type',
                'field' => 'wifis.security_type',
            ],
            [
                'name' => 'Name',
                'field' => 'wifis.ssid_name',
            ],
            [
                'name' => 'Password',
                'field' => 'wifis.ssid_password',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'wifis.ssid_name',
        $order = 'asc';

    public $hotels = [];

    public function mount() {
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = ModelsWifi::join('hotels', 'hotels.id', '=', 'wifis.hotel_id')
            ->select('wifis.*', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole('admin')) {
            $model = $model->where('wifis.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.hotel.wifi', compact('get'))->title($this->title);
    }

    public function customSave() {
        if($this->hotel_id) {
            $this->form->hotel_id = $this->hotel_id;
        }
        $this->save();
    }
}
