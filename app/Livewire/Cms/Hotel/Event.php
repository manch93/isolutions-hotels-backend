<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormEvent;
use App\Models\Hotel;
use App\Models\Event as EventModel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class Event extends BaseComponent
{
    use WithFileUploads;

    public FormEvent $form;
    public $title = 'Event';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'events.name',
            ],
            [
                'name' => 'Description',
                'field' => 'events.description',
            ],
            [
                'name' => 'Image',
                'field' => 'events.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'events.name',
        $order = 'asc';

    public $hotels = [];
    public $trix_description;

    public function mount() {
        $this->isModalOpen = true;
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = EventModel::join('hotels', 'hotels.id', '=', 'events.hotel_id')
            ->select('events.*', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole('admin')) {
            $model = $model->where('events.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.hotel.event', compact('get'))->title($this->title);
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
