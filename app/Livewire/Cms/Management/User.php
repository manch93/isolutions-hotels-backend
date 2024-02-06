<?php

namespace App\Livewire\Cms\Management;

use App\Livewire\Forms\Cms\Management\FormUser;
use Spatie\Permission\Models\Role;
use App\Models\Hotel;
use App\Models\User as UserModel;
use BaseComponent;

class User extends BaseComponent
{
    public FormUser $form;
    public $title = 'Management User';

    public $searchBy = [
            [
                'name' => 'Name',
                'field' => 'users.name',
            ],
            [
                'name' => 'Email',
                'field' => 'users.email',
            ],
            [
                'name' => 'Role',
                'field' => 'roles.name',
            ],
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'users.name',
        $order = 'asc';

    public $roles = [];
    public $hotels = [];

    public function mount() {
        if(auth()->user()->hasRole('admin_hotel')) {
            $this->roles = Role::where('name', 'receptionist')->get();
        } else {
            $this->roles = Role::all();
        }
        $this->hotels = Hotel::all();
    }

    public function render()
    {
        $model = UserModel::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->leftJoin('user_has_hotel', 'user_has_hotel.user_id', '=', 'users.id')
            ->leftJoin('hotels', 'hotels.id', '=', 'user_has_hotel.hotel_id')
            ->select('users.*', 'roles.name as role', 'hotels.name as hotel');

        // If user admin hotel
        if(auth()->user()->hasRole('admin_hotel')) {
            $model = $model->where('model_has_roles.role_id', '=', Role::findByName('receptionist')->id);
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

        return view('livewire.cms.management.user', compact('get'))->title($this->title);
    }
}
