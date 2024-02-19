<?php

namespace App\Livewire;

use App\Livewire\Forms\FormFrontDesk;
use Livewire\Attributes\On;
use App\Models\Room;
use App\Models\RoomType;
use BaseComponent;

class FrontDesk extends BaseComponent
{
    public FormFrontDesk $form;
    public $title = 'Front Desk';

    public $searchBy = [
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
                'name' => 'Is Birthday',
                'field' => 'rooms.is_birthday',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'rooms.no',
        $order = 'asc';

    public $roomTypes = [];
    public $whereRoomType = null;

    public function mount() {
        if($this->hotel_id) {
            $this->roomTypes = RoomType::where('hotel_id', $this->hotel_id)->get();
        }
    }

    public function render()
    {
        $model = Room::join('hotels', 'hotels.id', '=', 'rooms.hotel_id')
            ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
            ->select('rooms.*', 'hotels.name as hotel', 'room_types.name as room_type')
            ->where('hotels.id', $this->hotel_id)
            ->where('hotels.is_active', 1);

        // Where room type
        if($this->whereRoomType) {
            $model = $model->where('rooms.room_type_id', $this->whereRoomType);
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

        return view('livewire.front-desk', compact('get'))->title($this->title);
    }

    public function checkIn() {
        $this->form->checkIn();

        $this->dispatch('closeModal', modal: 'acc-modal');
        $this->dispatch('alert', message: 'Check In Success');
    }

    public function confirmCheckOut($id) {
        $this->dispatch('confirm', function: 'checkOut', id: $id);
    }

    #[On('checkOut')]
    public function checkOut($id) {
        $this->form->id = $id;
        $this->form->checkOut();

        $this->dispatch('closeModal', modal: 'acc-modal');
        $this->dispatch('alert', message: 'Check Out Success');
    }
}
