<?php

namespace App\Livewire\Cms\Master;

use App\Enums\Alert;
use App\Livewire\Forms\Cms\Master\FormHotel;
use App\Livewire\Forms\Cms\Master\FormHotelProfile;
use App\Models\Hotel as ModelsHotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class Hotel extends BaseComponent
{
    use WithFileUploads;

    public FormHotel $form;
    public FormHotelProfile $formProfile;
    public $title = 'Hotel';

    public $searchBy = [
            [
                'name' => 'Name',
                'field' => 'name',
            ],
            [
                'name' => 'Branch',
                'field' => 'branch',
            ],
            [
                'name' => 'Address',
                'field' => 'address',
            ],
            [
                'name' => 'Phone',
                'field' => 'phone',
            ],
            [
                'name' => 'Email',
                'field' => 'email',
            ],
            [
                'name' => 'Website',
                'field' => 'website',
            ],
            [
                'name' => 'Default Greeting',
                'field' => 'default_greeting',
            ],
            [
                'name' => 'Password Setting',
                'field' => 'password_setting',
            ],
            [
                'name' => 'Is Active',
                'field' => 'is_active',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'name',
        $order = 'asc';

    public $type;

    public function mount() {
        // Add new modal
        $this->addModal('modalProfile');

        if($this->originRoute == 'cms.master.hotel') {
            $this->type = 'hotel';
            $this->title = 'Hotel';
        } else {
            $this->type = 'hospital';
            $this->title = 'Hospital';
        }
    }

    public function render()
    {
        $model = new ModelsHotel;

        // If user not admin
        if(!auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $model = $model->where('id', $this->hotel_id);
        }

        // If user admin reseller
        if(auth()->user()->hasRole('admin_reseller')) {
            $model = $model->where('user_id', auth()->user()->id);
        }

        $model = $model->where('type', $this->type);

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.master.hotel', compact('get'))->title($this->title);
    }

    public function customSave() {
        $this->form->type = $this->type;
        $this->save();
    }

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $logo_color;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $logo_white;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $logo_black;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $main_photo;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $background_photo;

    #[Validate('nullable|mimes:mp4,ogx,oga,ogv,ogg,webm,mkv')]
    public $intro_video;

    public $trix_description;

    public function getProfile($id) {
        $this->formProfile->getDetail($id);
        $this->trix_description = $this->formProfile->description;
        $this->openModal('modalProfile');
    }

    public function closeModalProfile() {
        $this->closeModal('modalProfile');
    }

    public function saveProfile() {
        $this->formProfile->logo_color = $this->logo_color;
        $this->formProfile->logo_white = $this->logo_white;
        $this->formProfile->logo_black = $this->logo_black;
        $this->formProfile->main_photo = $this->main_photo;
        $this->formProfile->background_photo = $this->background_photo;
        $this->formProfile->intro_video = $this->intro_video;
        $this->formProfile->description = $this->trix_description;
        $this->imageIttr++;
        $this->formProfile->save();
        $this->logo_color = null;
        $this->logo_white = null;
        $this->logo_black = null;
        $this->main_photo = null;
        $this->background_photo = null;
        $this->intro_video = null;
        $this->trix_description = null;

        $this->closeModalProfile();
        $this->dispatch('alert', type: Alert::success, message: 'Hotel Profile Updated');
    }
}
