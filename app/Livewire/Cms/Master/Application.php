<?php

namespace App\Livewire\Cms\Master;

use BaseComponent;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Application as ModelsApplication;
use App\Livewire\Forms\Cms\Master\FormApplication;

class Application extends BaseComponent
{
    use WithFileUploads;
    public FormApplication $form;
    public $title = 'Application';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Name',
                'field' => 'applications.name',
            ],
            [
                'name' => 'Package Name',
                'field' => 'applications.package_name',
            ],
            [
                'name' => 'Image',
                'field' => 'applications.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'applications.name',
        $order = 'asc';

    public function render()
    {
        $model = ModelsApplication::join('hotels', 'hotels.id', '=', 'applications.hotel_id')
            ->select('applications.*', 'hotels.name as hotel')
            ->where('applications.is_deleted', false);

        // If user not admin
        if(!auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $model = $model->where('applications.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.master.application', compact('get'))->title($this->title);
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
        $this->trix_description = null;
    }
}
