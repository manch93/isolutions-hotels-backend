<?php

namespace App\Livewire\Cms\Master;

use App\Livewire\Forms\Cms\Master\FormRoomType;
use App\Models\Hotel;
use App\Models\RoomType as ModelsRoomType;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class RoomType extends BaseComponent
{
    use WithFileUploads;

    public FormRoomType $form;
    public $title = 'Room Type';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
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
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'room_types.name',
        $order = 'asc';

    public $hotels;
    public $trix_description;

    public function mount() {
        $this->isModalOpen = true;
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = ModelsRoomType::join('hotels', 'hotels.id', '=', 'room_types.hotel_id')
            ->select('room_types.*', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole('admin')) {
            $model = $model->where('room_types.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.master.room-type', compact('get'))->title($this->title);
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
