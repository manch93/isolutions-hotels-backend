<?php

namespace App\Livewire\Cms\Doc;

use App\Livewire\Forms\Cms\Doc\FormDocumentation;
use App\Models\Documentation;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use BaseComponent;

class CreateUpdate extends BaseComponent
{
    use WithFileUploads;

    public $title = 'Documentation';
    public $isUpdate = false;

    public FormDocumentation $form;
    public $menus = [];

    // Trix
    public $trix_photos = [];
    public $trix_content = '';


    public function mount($id = null) {
        $this->getMenu($id);

        $this->title = 'Create ' . $this->title;

        if($id) {

            $this->title = 'Update ' . $this->title;
            $this->form->getDetail($id);
            $this->trix_content = $this->form->description;
            $this->isUpdate = true;
        }
    }

    public function getMenu($id = null) {
        $documentation = Documentation::whereNot('id', $id)->pluck('menu_id')->toArray();

        $this->menus = Menu::where('on', 'docs')->whereNotIn('id', $documentation)->get();
    }

    public function render()
    {
        return view('livewire.cms.doc.create-update')->title($this->title);
    }

    // Trix upload file
    public function completeUpload(string $uploadedUrl, string $trixUploadCompletedEvent){
        foreach($this->trix_photos as $photo) {
            if($photo->getFilename() == $uploadedUrl) {
                // store in the public/photos location
                $newFilename = $photo->store('public/photos');

                // get the public URL of the newly uploaded file
                $url = Storage::url($newFilename);

                $this->dispatch($trixUploadCompletedEvent, [
                    'url' => $url,
                    'href' => $url,
                ]);
            }
        }
    }

    public function customSave() {
        $this->form->description = $this->trix_content;

        $this->save();

        $this->redirectRoute('cms.docs');
    }
}
