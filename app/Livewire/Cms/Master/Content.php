<?php

namespace App\Livewire\Cms\Master;

use App\Livewire\BaseComponent;
use App\Livewire\Forms\Cms\Master\FormContent;
use App\Models\Content as ModelsContent;
use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class Content extends BaseComponent
{
    use WithFileUploads;

    public FormContent $form;
    public $title = 'Content';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Name',
                'field' => 'contents.name',
            ],
            [
                'name' => 'Image',
                'field' => 'contents.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'contents.name',
        $order = 'asc';

    public $hotels = [];

    public function mount() {
        if(auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $this->hotels = Hotel::where('type', 'hotel')->get();
        }
    }

    public function render()
    {
        $model = ModelsContent::join('hotels', 'hotels.id', '=', 'contents.hotel_id')
            ->select('contents.*', 'hotels.name as hotel')
            ->where('contents.is_deleted', false);

        // If user not admin
        if(!auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $model = $model->where('contents.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.master.content', compact('get'))->title($this->title);
    }

    public function customEdit($id) {
        $this->edit($id);
    }

    public function saveWithUpload() {
        if($this->hotel_id) {
            $this->form->hotel_id = $this->hotel_id;
        }
        $this->form->image = $this->image;
        $this->save();
        $this->image = null;
    }
}
