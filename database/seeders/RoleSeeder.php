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
    public $receptionistPermission = [
        'cms.dashboard',
        'cms.front-desk',
    ];
    public $adminHotelPermission = [
        'cms.dashboard',
        'cms.front-desk',
        'cms.master.hotel',
        'cms.master.room-type',
        'cms.master.room',
        'cms.hotel.facility',
        'cms.hotel.around',
        'cms.hotel.promo',
        'cms.hotel.food',
        'cms.hotel.policy',
        'cms.management.user',
        'cms.management.access-control',
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
                    if(!$route == 'cms.front-desk') {
                        $admin->givePermissionTo($permission);
                    }

                    // Give admin hotel permission
                    if(in_array($route, $this->adminHotelPermission)) {
                        $adminHotel->givePermissionTo($permission);
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
