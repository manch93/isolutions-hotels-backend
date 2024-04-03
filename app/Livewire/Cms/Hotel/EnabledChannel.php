<?php

namespace App\Livewire\Cms\Hotel;

use App\Livewire\Forms\Cms\Hotel\FormEnabledChannel;
use App\Models\M3uSource;
use App\Models\M3uChannel;
use App\Models\Hotel;
use App\Models\HotelChannelEnabled;
use BaseComponent;

class EnabledChannel extends BaseComponent
{
    public FormEnabledChannel $form;
    public $title = 'Enabled Channel Hotel - ';

    public $searchBy = [
            [
                'name' => 'Hotel',
                'field' => 'hotels.name',
            ],
            [
                'name' => 'Source',
                'field' => 'm3u_sources.name',
            ],
            [
                'name' => 'Channel',
                'field' => 'm3u_channels.name',
            ],
            [
                'name' => 'Active',
                'field' => 'hotel_channel_enabled.active',
            ],
        ],
        $isUpdate = false,
        $search = '',
        $paginate = 10,
        $orderBy = 'hotels.name',
        $order = 'asc';

    public $hotel;
    public $source;
    public $source_id;
    public $channel = [];

    public function mount($id) {
        $this->hotel = Hotel::find($id);

        $this->title .= $this->hotel->name;
        $this->source = M3uSource::all();
    }

    public function render()
    {
        $model = HotelChannelEnabled::join('hotels', 'hotels.id', '=', 'hotel_channel_enabled.hotel_id')
            ->join('m3u_channels', 'm3u_channels.id', '=', 'hotel_channel_enabled.m3u_channel_id')
            ->join('m3u_sources', 'm3u_sources.id', '=', 'm3u_channels.m3u_source_id')
            ->where('hotel_channel_enabled.hotel_id', $this->hotel->id)
            ->select('hotel_channel_enabled.*', 'hotels.name as hotel', 'm3u_channels.name as channel', 'm3u_sources.name as source');

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.hotel.enabled-channel', compact('get'))->title($this->title);
    }

    public function customCreate() {
        $this->create();
        $this->source_id = null;
    }

    public function customEdit($id) {
        $this->edit($id);

        $channel = M3uChannel::find($this->form->m3u_channel_id);
        $this->source_id = $channel->m3u_source_id;
        $this->channel = M3uChannel::where('m3u_source_id', $this->source_id)->get();
    }

    public function getChannelFromSource() {
        $this->channel = M3uChannel::where('m3u_source_id', $this->source_id)->get();
    }

    public function activateAll() {
        $this->form->activateAll($this->hotel->id);
    }

    public function deactivateAll() {
        $this->form->deactivateAll($this->hotel->id);
    }

    public function customSave() {
        $this->form->hotel_id = $this->hotel->id;

        $this->save();
    }
}
