<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public $permissionType = [
        'view',
        'create',
        'update',
        'delete',
    ];
    public $routeExcept = [
        'sanctum.csrf-cookie',
        'livewire.update',
        'livewire.upload-file',
        'livewire.preview-file',
        'ignition.healthCheck',
        'ignition.executeSolution',
        'ignition.updateConfig',
        'profile.edit',
        'profile.update',
        'profile.destroy',
        'login',
        'password.confirm',
        'password.update',
        'logout',
    ];
    public $adminExcept = [
        'cms.front-desk',
        'cms.master.room-type',
        'cms.master.room',
        'cms.hotel.facility',
        'cms.hotel.around',
        'cms.hotel.promo',
        'cms.hotel.food-category',
        'cms.hotel.food',
        'cms.hotel.policy',
        'cms.hotel.event',
        'cms.hotel.wifi',
        'cms.hospital.doctor-category',
        'cms.hospital.doctor',
    ];
    public $adminResellerExcept = [
        'cms.front-desk',
        'cms.docs',
        'cms.docs.create-update',
        'cms.master.room-type',
        'cms.master.room',
        'cms.hotel.facility',
        'cms.hotel.around',
        'cms.hotel.promo',
        'cms.hotel.food-category',
        'cms.hotel.food',
        'cms.hotel.policy',
        'cms.hotel.event',
        'cms.hotel.wifi',
        'cms.hospital.doctor-category',
        'cms.hospital.doctor',
        'cms.management.menu',
        'cms.management.m3u-channel',
        'cms.management.m3u-channel.detail',
        'cms.management.role',
        'cms.management.role-permission',
        'cms.management.setting',
        'cms.management.access-control',
        'cms.management.privacy-policy',
        'cms.management.term-of-service',
    ];
    public $receptionistPermission = [
        'cms.dashboard',
        'cms.front-desk',
    ];
    public $adminHotelPermission = [
        'cms.dashboard',
        'cms.front-desk',
        'cms.master.hospital',
        'cms.master.hotel',
        'cms.master.room-type',
        'cms.master.feature',
        'cms.master.room',
        'cms.hotel.facility',
        'cms.hotel.around',
        'cms.hotel.promo',
        'cms.hotel.food-category',
        'cms.hotel.food',
        'cms.hotel.policy',
        'cms.hotel.event',
        'cms.hotel.wifi',
        'cms.management.user',
        'cms.management.access-control',
        'cms.hospital.doctor-category',
        'cms.hospital.doctor',
    ];

    public function run(): void
    {
        // Hotel app
        $admin = Role::findOrCreate('admin', 'web');
        $receptionist = Role::findOrCreate('receptionist', 'web');
        $adminHotel = Role::findOrCreate('admin_hotel', 'web');
        $adminReseller = Role::findOrCreate('admin_reseller', 'web');

        // Generate Permission
        // Get all route names
        $routes = Route::getRoutes();

        foreach ($routes as $value) {
            $route = $value->getName();
            // Except route
            if(!in_array($route, $this->routeExcept) && !is_null($route)) {
                foreach($this->permissionType as $type) {
                    $permission = $type . '.' . $route;
                    $permission = Permission::findOrCreate($permission, 'web');

                    // Give admin permission
                    if(!in_array($route, $this->adminExcept)) {
                        $admin->givePermissionTo($permission);
                    }

                    // Give admin reseller permission
                    if(!in_array($route, $this->adminResellerExcept)) {
                        $adminReseller->givePermissionTo($permission);
                    }

                    // Give admin hotel permission
                    if(in_array($route, $this->adminHotelPermission)) {
                        if($route == 'cms.master.hotel' ) {
                            // Where menu hotel, give permission only to view and edit
                            if($type == 'view' || $type == 'update') {
                                $adminHotel->givePermissionTo($permission);
                            }
                        } else {
                            $adminHotel->givePermissionTo($permission);
                        }
                    }

                    // Give receptionist permission
                    if(in_array($route, $this->receptionistPermission)) {
                        $receptionist->givePermissionTo($permission);
                    }
                }
            }
        }
    }
}
