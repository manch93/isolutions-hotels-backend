<?php

namespace App\Livewire\Cms\Master;

use App\Livewire\Forms\Cms\Master\FormRoom;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Room as ModelsRoom;
use BaseComponent;

class Room extends BaseComponent
{
    public FormRoom $form;
    public $title = 'Room';

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Room Type',
                'field' => 'room_types.name',
            ],
            [
                'name' => 'No',
                'field' => 'rooms.no',
            ],
            [
                'name' => 'Guest Name',
                'field' => 'rooms.guest_name',
            ],
            [
                'name' => 'Greeting',
                'field' => 'rooms.greeting',
            ],
            [
                'name' => 'Device Name',
                'field' => 'rooms.device_name',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'rooms.no',
        $order = 'asc';

    public $hotels = [];
    public $roomTypes = [];

    public function mount() {
        $this->hotels = Hotel::all();
    }

    public function getRoomType() {
        $this->roomTypes = RoomType::where('hotel_id', $this->form->hotel_id)->get();
    }

    public function render()
    {
        $model = ModelsRoom::join('hotels', 'hotels.id', '=', 'rooms.hotel_id')
            ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
            ->select('rooms.*', 'hotels.name as hotel', 'room_types.name as room_type');

        // If user not admin
        if(!auth()->user()->hasRole('admin')) {
            $model = $model->where('rooms.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.master.room', compact('get'))->title($this->title);
    }
}
