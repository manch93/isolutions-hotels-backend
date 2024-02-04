<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hotel app
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('receptionist', 'web');
        Role::findOrCreate('admin_hotel', 'web');
    }
}
