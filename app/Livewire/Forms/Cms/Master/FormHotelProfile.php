<?php

namespace App\Livewire\Forms\Cms\Master;

use App\Models\HotelProfile;
use App\Traits\WithSaveFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormHotelProfile extends Form
{
    use WithSaveFile;

    public $hotel;

    #[Validate('required|numeric')]
    public $hotel_id;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $logo_color;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $logo_white;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $logo_black;

    #[Validate('required|string')]
    public $primary_color;

    #[Validate('required|string')]
    public $description;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $main_photo;

    #[Validate('nullable|image:jpeg,png,jpg,svg')]
    public $background_photo;

    #[Validate('nullable|mimes:mp4,ogx,oga,ogv,ogg,webm,mkv')]
    public $intro_video;

    #[Validate('nullable|string')]
    public $running_text;

    #[Validate('required|string')]
    public $welcome_text;

    #[Validate('nullable|string|max:255')]
    public $instagram_username;

    #[Validate('nullable|string|max:255')]
    public $facebook_username;

    public function getDetail($id) {
        $data = HotelProfile::where('hotel_id', $id)->first();

        $this->hotel = $data->hotel->name;
        $this->hotel_id = $data->hotel_id;
        $this->logo_color = $data->logo_color;
        $this->logo_white = $data->logo_white;
        $this->logo_black = $data->logo_black;
        $this->primary_color = $data->primary_color;
        $this->description = $data->description;
        $this->main_photo = $data->main_photo;
        $this->background_photo = $data->background_photo;
        $this->intro_video = $data->intro_video;
        $this->running_text = $data->running_text;
        $this->welcome_text = $data->welcome_text;
        $this->instagram_username = $data->instagram_username;
        $this->facebook_username = $data->facebook_username;
    }

    public function save() {
        $this->validate();

        $old = HotelProfile::where('hotel_id', $this->hotel_id)->first();
        $save_path = HotelProfile::$FILE_PATH;

        // Save image
        if($this->logo_color) {
            $this->logo_color = $this->saveFile($this->logo_color, $save_path, $save_path)['filename'];
        } else {
            $this->logo_color = $old->logo_color;
        }

        if($this->logo_white) {
            $this->logo_white = $this->saveFile($this->logo_white, $save_path, $save_path)['filename'];
        } else {
            $this->logo_white = $old->logo_white;
        }

        if($this->logo_black) {
            $this->logo_black = $this->saveFile($this->logo_black, $save_path, $save_path)['filename'];
        } else {
            $this->logo_black = $old->logo_black;
        }

        if($this->main_photo) {
            $this->main_photo = $this->saveFile($this->main_photo, $save_path, $save_path)['filename'];
        } else {
            $this->main_photo = $old->main_photo;
        }

        if($this->background_photo) {
            $this->background_photo = $this->saveFile($this->background_photo, $save_path, $save_path)['filename'];
        } else {
            $this->background_photo = $old->background_photo;
        }

        if($this->intro_video) {
            $this->intro_video = $this->saveFile($this->intro_video, $save_path, $save_path)['filename'];
        } else {
            $this->intro_video = $old->intro_video;
        }

        $old->update($this->only([
            'logo_color',
            'logo_white',
            'logo_black',
            'primary_color',
            'description',
            'main_photo',
            'background_photo',
            'intro_video',
            'running_text',
            'welcome_text',
            'instagram_username',
            'facebook_username',
        ]));
    }
}
