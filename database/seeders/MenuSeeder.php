<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::truncate();
        Menu::insert([
            [
                'name' => 'Dashboard',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'home',
                'route' => 'cms.dashboard',
                'ordering' => '1',
            ],
            [
                'name' => 'Front Desk',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'book-open',
                'route' => 'cms.front-desk',
                'ordering' => '2',
            ],
            // Master Data
            [
                'name' => 'Master',
                'on' => 'cms',
                'type' => 'header',
                'icon' => '#',
                'route' => '#',
                'ordering' => '10',
            ],
            [
                'name' => 'Hotel',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'briefcase',
                'route' => 'cms.master.hotel',
                'ordering' => '11',
            ],
            [
                'name' => 'Room Type',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'tag',
                'route' => 'cms.master.room-type',
                'ordering' => '12',
            ],
            [
                'name' => 'Room',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'save',
                'route' => 'cms.master.room',
                'ordering' => '13',
            ],
            // Hotel
            [
                'name' => 'Hotel',
                'on' => 'cms',
                'type' => 'header',
                'icon' => '#',
                'route' => '#',
                'ordering' => '20',
            ],
            [
                'name' => 'Facility',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'archive',
                'route' => 'cms.hotel.facility',
                'ordering' => '21',
            ],
            [
                'name' => 'Around',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'globe',
                'route' => 'cms.hotel.around',
                'ordering' => '22',
            ],
            [
                'name' => 'Promo',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'percent',
                'route' => 'cms.hotel.promo',
                'ordering' => '23',
            ],
            [
                'name' => 'Food',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'book-open',
                'route' => 'cms.hotel.food',
                'ordering' => '24',
            ],
            // Settings
            [
                'name' => 'Settings',
                'on' => 'cms',
                'type' => 'header',
                'icon' => '#',
                'route' => '#',
                'ordering' => '30',
            ],
            [
                'name' => 'Menu',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'menu',
                'route' => 'cms.management.menu',
                'ordering' => '32',
            ],
            [
                'name' => 'Role',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'lock',
                'route' => 'cms.management.role',
                'ordering' => '33',
            ],
            [
                'name' => 'User',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'user',
                'route' => 'cms.management.user',
                'ordering' => '34',
            ],
            [
                'name' => 'Website',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'settings',
                'route' => 'cms.management.setting',
                'ordering' => '35',
            ],
            [
                'name' => 'Access Control',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'key',
                'route' => 'cms.management.access-control',
                'ordering' => '36',
            ],
            [
                'name' => 'Privacy Policies',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'file',
                'route' => 'cms.management.privacy-policy',
                'ordering' => '37',
            ],
            [
                'name' => 'Terms Of Service',
                'on' => 'cms',
                'type' => 'item',
                'icon' => 'file',
                'route' => 'cms.management.term-of-service',
                'ordering' => '38',
            ],
        ]);
    }
}
