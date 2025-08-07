<?php

namespace App\Livewire\Cms\Master;

use App\Livewire\BaseComponent;
use App\Livewire\Forms\Cms\Master\FormContentItem;
use App\Models\ContentItem as ModelsContentItem;
use App\Models\Content;
use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class ContentItem extends BaseComponent
{
    use WithFileUploads;

    public FormContentItem $form;
    public $title = 'Content Item';

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $image;

    public $searchBy = [
            [
                'name' => 'Content',
                'field' => 'contents.name',
            ],
            [
                'name' => 'Name',
                'field' => 'content_items.name',
            ],
            [
                'name' => 'Description',
                'field' => 'content_items.description',
            ],
            [
                'name' => 'Image',
                'field' => 'content_items.image',
                'no_search' => true,
            ],
            [
                'name' => 'Is Active',
                'field' => 'content_items.is_active',
                'no_search' => true,
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'content_items.name',
        $order = 'asc';

    public $contents = [];
    public $hotels = [];
    public $filterByContent = ''; // Filter untuk content

    public function mount() {
        if(auth()->user()->hasRole(['admin', 'admin_reseller'])) {
            $this->hotels = Hotel::where('type', 'hotel')->get();
            $this->contents = Content::where('is_deleted', false)->where('is_active', true)->get();
        } else {
            $this->contents = Content::where('is_deleted', false)
                ->where('is_active', true)
                ->where('hotel_id', $this->hotel_id)
                ->get();
        }
    }

    public function render()
    {
        $model = ModelsContentItem::join('contents', 'contents.id', '=', 'content_items.content_id')
            ->select('content_items.*', 'contents.name as content')
            ->where('content_items.is_deleted', false)
            ->where('contents.is_deleted', false); // Don't show content items with deleted content

        // Filter by content if selected
        if ($this->filterByContent) {
            $model = $model->where('content_items.content_id', $this->filterByContent);
        }

        // If user not admin, filter by hotel
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

        return view('livewire.cms.master.content-item', compact('get'));
    }

    public function customEdit($id) {
        $this->edit($id);
    }

    public function saveWithUpload() {
        $this->form->image = $this->image;
        $this->save();
        $this->image = null;
    }

    // Get contents based on hotel selection (for admin)
    public function updatedFormHotelId($hotel_id) {
        $this->getContentsByHotel($hotel_id);
    }

    // Reset page when filter changes
    public function updatedFilterByContent() {
        $this->resetPage();
    }

    // Reset filter
    public function resetContentFilter() {
        $this->filterByContent = '';
        $this->resetPage();
    }

    public function getContentsByHotel($hotel_id = null) {
        if ($hotel_id) {
            $this->contents = Content::where('is_deleted', false)
                ->where('is_active', true)
                ->where('hotel_id', $hotel_id)
                ->get();
        } else {
            $this->contents = Content::where('is_deleted', false)->where('is_active', true)->get();
        }
        
        // Reset content_id selection when hotel changes
        $this->form->content_id = '';
    }
}
