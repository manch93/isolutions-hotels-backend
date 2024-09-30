<?php

namespace App\Livewire\Cms\Hospital;

use App\Livewire\Forms\Cms\Hospital\FormDoctorCategory;
use App\Models\Hotel;
use App\Models\DoctorCategory as ModelsDoctorCategory;
use BaseComponent;

class DoctorCategory extends BaseComponent
{
    public FormDoctorCategory $form;
    public $title = 'Doctor Category';

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Name',
                'field' => 'doctor_categories.name',
            ],
            [
                'name' => 'Description',
                'field' => 'doctor_categories.description',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'doctor_categories.name',
        $order = 'asc';

    public $hotels = [];
    public $trix_description;

    public function mount() {
        $this->hotels = Hotel::where('type', 'hospital')->get();
    }

    public function render()
    {
        $model = ModelsDoctorCategory::join('hotels', 'hotels.id', '=', 'doctor_categories.hotel_id')
            ->select('doctor_categories.*', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $model = $model->where('doctor_categories.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.hospital.doctor-category', compact('get'))->title($this->title);
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
