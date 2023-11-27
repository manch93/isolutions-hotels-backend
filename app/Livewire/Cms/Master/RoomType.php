<?php

namespace App\Livewire\Cms\Master;

use App\Livewire\Forms\Cms\Master\FormRoomType;
use App\Models\Hotel;
use App\Models\RoomType as ModelsRoomType;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use BaseComponent;

class RoomType extends BaseComponent
{
    use WithFileUploads;

    public FormRoomType $form;
    public $title = 'Room Type';

    #[Rule('nullable|image:jpeg,png,jpg,svg|max:2048')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'room_types.name',
            ],
            [
                'name' => 'Description',
                'field' => 'room_types.description',
            ],
            [
                'name' => 'Image',
                'field' => 'room_types.image',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'room_types.name',
        $order = 'asc';

    public $hotels;

    public function mount() {
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = ModelsRoomType::join('hotels', 'hotels.id', '=', 'room_types.hotel_id')
            ->select('room_types.*', 'hotels.name as hotel');

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.master.room-type', compact('get'))->title($this->title);
    }

    public function saveWithUpload() {
        $this->form->image = $this->image;
        $this->save();
    }
}
