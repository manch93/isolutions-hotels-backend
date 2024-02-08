<?php

namespace App\Livewire\Cms\Management;

use App\Livewire\Forms\Cms\Management\FormM3uSource;
use App\Models\M3uSource as M3uSourceModel;
use BaseComponent;

class M3uSource extends BaseComponent
{
    public FormM3uSource $form;
    public $title = 'M3U Source';

    public $searchBy = [
            [
                'name' => 'Name',
                'field' => 'name',
            ],
            [
                'name' => 'URL',
                'field' => 'url',
            ],
            [
                'name' => 'Type',
                'field' => 'type',
            ],
            [
                'name' => 'Headers',
                'field' => 'headers',
            ],
            [
                'name' => 'Body',
                'field' => 'body',
            ],
            [
                'name' => 'Channel',
                'field' => 'name',
                'no_search' => true,
            ],
            [
                'name' => 'Active',
                'field' => 'active',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'name',
        $order = 'asc';

    public function render()
    {
        $model = M3uSourceModel::withCount('channels');

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.management.m3u-source', compact('get'))->title($this->title);
    }
}
