<?php

namespace App\Livewire\Cms\Management;

use App\Livewire\Forms\Cms\Management\FormM3uSourceChannel;
use App\Models\M3uSource;
use App\Models\M3uChannel;
use App\Enums\Alert;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use BaseComponent;

class M3uSourceChannel extends BaseComponent
{
    use WithFileUploads;

    public FormM3uSourceChannel $form;
    public $title = ' Channel';

    #[Validate('nullable|image:jpeg,png,jpg,svg|max:2048')]
    public $image;

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
                'name' => 'Icon',
                'field' => 'icon',
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

    public $source = null;

    public function mount($source = null) {
        $source = M3uSource::find($source);

        if($source) {
            $this->source = $source;
            $this->title = $source->name . $this->title;
        }
    }

    public function render()
    {
        $model = M3uChannel::where('m3u_source_id', $this->source->id);

        $get = $this->getDataWithFilter($model, [
            'orderBy' => $this->orderBy,
            'order' => $this->order,
            'paginate' => $this->paginate,
            's' => $this->search,
        ], $this->searchBy);

        if ($this->search != null) {
            $this->resetPage();
        }

        return view('livewire.cms.management.m3u-source-channel', compact('get'))->title($this->title);
    }

    public function customSave() {
        $this->form->icon = $this->image;
        $this->save();
    }

    public function activateChannel($id) {
        $this->form->activateChannel($id);
    }

    public function deactivateChannel($id) {
        $this->form->deactivateChannel($id);
    }

    public function activateAll() {
        $this->form->activateAll($this->source->id);
    }

    public function deactivateAll() {
        $this->form->deactivateAll($this->source->id);
    }

    public function callApi() {
        // Call Api
        $ch = curl_init();
        $url = $this->source->url;
        $type = $this->source->type;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Headers
        $headers = $this->source->headers;
        if(!empty($headers)) {
            $headers = json_decode($headers, true);
            foreach ($headers as $key => $value) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array($key . ': ' . $value));
            }
        }

        // Body
        $body = $this->source->body;
        if(!empty($body)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $output = curl_exec($ch);
        curl_close($ch);

        preg_match_all('/(?P<tag>#EXTINF:-1)|(?:(?P<prop_key>[-a-z]+)=\"(?P<prop_val>[^"]+)")|(?<something>,[^\r\n]+)|(?<url>http[^\s]+)/', $output, $match);

        $count = count($match[0]);
        $result = [];
        $index = -1;

        for ($i = 0; $i < $count; $i++) {
            $item = $match[0][$i];

            if (!empty($match['tag'][$i])) {
                //is a tag increment the result index
                ++$index;
            } elseif (!empty($match['prop_key'][$i])) {
                //is a prop - split item
                $result[$index][$match['prop_key'][$i]] = $match['prop_val'][$i];
            } elseif (!empty($match['something'][$i])) {
                //is a prop - split item
                $result[$index]['name'] = str_replace(',', '', $item);
            } elseif (!empty($match['url'][$i])) {
                $result[$index]['url'] = $item;
            }
        }

        // Save to database
        foreach ($result as $item) {
            M3uChannel::updateOrCreate([
                'm3u_source_id' => $this->source->id,
                'name' => $item['name'],
            ], [
                'url' => $item['url'],
                'active' => 1,
            ]);
        }

        $this->dispatch('alert', type: Alert::success, message: 'All Channel Updated');
    }
}
