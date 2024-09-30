<?php

namespace App\Livewire\Cms\Hospital;

use App\Livewire\Forms\Cms\Hospital\FormDoctor;
use App\Models\Doctor as ModelsDoctor;
use App\Models\DoctorCategory;
use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class Doctor extends BaseComponent
{
    use WithFileUploads;

    public FormDoctor $form;
    public $title = 'Doctor';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Category',
                'field' => 'doctor_categories.name',
            ],
            [
                'name' => 'Name',
                'field' => 'doctors.name',
            ],
            [
                'name' => 'Description',
                'field' => 'doctors.description',
            ],
            [
                'name' => 'Image',
                'field' => 'doctors.image',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'doctors.name',
        $order = 'asc';

    public $hotels = [];
    public $doctorCategories = [];
    public $trix_description;

    public function mount() {
        $this->hotels = Hotel::all();

        if(!auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $this->doctorCategories = DoctorCategory::where('hotel_id', $this->hotel_id)->get();
        }
    }

    public function render()
    {
        $model = ModelsDoctor::join('hotels', 'hotels.id', '=', 'doctors.hotel_id')
            ->join('doctor_categories', 'doctor_categories.id', '=', 'doctors.doctor_category_id')
            ->select('doctors.*', 'doctor_categories.name as doctor_category', 'hotels.name as hotel');

        // If user not admin
        if(!auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $model = $model->where('doctors.hotel_id', $this->hotel_id);
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

        return view('livewire.cms.hospital.doctor', compact('get'))->title($this->title);
    }

    public function customEdit($id) {
        $this->edit($id);
        $this->getDoctorCategory();
        $this->dispatch('setValueById', id: 'doctor_category_id', value: $this->form->doctor_category_id);
        $this->trix_description = $this->form->description;
    }

    public function getDoctorCategory() {
        $this->doctorCategories = DoctorCategory::where('hotel_id', $this->form->hotel_id)->get();
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
