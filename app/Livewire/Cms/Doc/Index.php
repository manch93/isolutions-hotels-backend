<?php

namespace App\Livewire\Cms\Doc;

use App\Models\Documentation;
use BaseComponent;

class Index extends BaseComponent
{
    public $title = 'Documentation';

    public $searchBy = [
            [
                'name' => 'Menu',
                'field' => 'menus.name',
            ],
            [
                'name' => 'Title',
                'field' => 'documentations.title',
            ],
            [
                'name' => 'image',
                'field' => 'documentations.image',
                'no_search' => true,
            ],
            [
                'name' => 'Order',
                'field' => 'menus.ordering',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'menus.ordering',
        $order = 'asc';

    public function render()
    {
        $model = Documentation::leftJoin('menus', 'menus.id', '=', 'documentations.menu_id')
            ->select('documentations.*', 'menus.name as menu', 'menus.ordering as ordering');

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.doc.index', compact('get'))->title($this->title);
    }

    public function customCreate() {
        $this->redirectRoute('cms.docs.create-update');
    }

    public function customEdit($id) {
        $this->redirectRoute('cms.docs.create-update', [
            'id' => $id
        ]);
    }
}
