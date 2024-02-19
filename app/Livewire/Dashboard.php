<?php

namespace App\Livewire;

use App\Models\M3uChannel;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public $hotel_id;

    public function mount() {
        $this->hotel_id = auth()->user()->userHotel?->hotel_id;
    }

    public function render()
    {
        // If admin
        if(auth()->user()->hasRole('admin')) {
            $hotel = Hotel::count();
            $user = User::count();
            $channel = M3uChannel::count();

            return view('livewire.dashboard-admin', compact(
                'hotel',
                'user',
                'channel',
            ));
        // Else Hotel
        } else {
            $room = Room::where('hotel_id', $this->hotel_id)->orderBy('guest_name', 'desc')->get();
            $roomOccupied = Room::where('hotel_id', $this->hotel_id)->whereNotNull('guest_name')->count();
            $roomEmpty = Room::where('hotel_id', $this->hotel_id)->whereNull('guest_name')->count();

            return view('livewire.dashboard-hotel', compact(
                'room',
                'roomOccupied',
                'roomEmpty',
            ));
        }
    }
}
