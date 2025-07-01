<?php

namespace App\Livewire;

use App\Livewire\BaseComponent;
use App\Livewire\Forms\FormFeatureCategory;

class Feature extends BaseComponent
{
    public FormFeatureCategory $form;
    public $title = 'Feature';
    public $searchBy = [
        [
            'name' => 'Name',
            'field' => 'feature_categories.name',
        ],
    ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'feature_categories.name',
        $order = 'asc';

    public function render()
    {
        $model = \App\Models\FeatureCategory::query();
        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.feature', compact('get'))->title($this->title);
    }
}
