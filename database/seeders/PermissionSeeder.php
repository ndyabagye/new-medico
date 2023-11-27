<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // permission structure according to shield spatie plugin
        $permissions = [
            'view_role',
            'view_any_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',

            'view_user',
            'view_any_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',

            'view_patient',
            'view_any_patient',
            'create_patient',
            'update_patient',
            'delete_patient',
            'delete_any_patient',

            'view_doctor',
            'view_any_doctor',
            'create_doctor',
            'update_doctor',
            'delete_doctor',
            'delete_any_doctor',

            'view_appointment',
            'view_any_appointment',
            'create_appointment',
            'update_appointment',
            'delete_appointment',
            'delete_any_appointment',

        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
