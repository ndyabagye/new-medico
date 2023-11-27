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
        $superAdmin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        $doctor = Role::create(['name' => 'doctor']);
        $patient = Role::create(['name' => 'patient']);

        $superAdmin->givePermissionTo([
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
        ]);

        $admin->givePermissionTo([
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
        ]);

        $doctor->givePermissionTo([
            'view_appointment',
            'view_any_appointment',
            'create_appointment',
            'update_appointment',
            'delete_appointment',
        ]);

        $patient->givePermissionTo([
            'view_appointment',
            'update_appointment',
        ]);
    }
}
