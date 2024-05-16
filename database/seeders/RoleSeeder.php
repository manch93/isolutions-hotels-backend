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
