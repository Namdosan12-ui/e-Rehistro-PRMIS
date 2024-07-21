<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions to create
        $permissions = [
            'manage users',
            'view reports',
            'manage patients',
            'manage laboratory',
            'manage transactions',
            'manage queuing',
            'send emails',
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Create roles and assign existing permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $frontDeskRole = Role::firstOrCreate(['name' => 'front desk']);
        $frontDeskRole->syncPermissions(['manage patients', 'manage transactions', 'manage queuing']);

        $radiologistRole = Role::firstOrCreate(['name' => 'radiologist']);
        $radiologistRole->syncPermissions(['manage laboratory', 'send emails']);

        $medTechRole = Role::firstOrCreate(['name' => 'medical technologist']);
        $medTechRole->syncPermissions(['manage laboratory', 'send emails']);

        $physicianRole = Role::firstOrCreate(['name' => 'physician']);
        $physicianRole->syncPermissions(['view reports', 'manage patients']);

        $pharmacyStaffRole = Role::firstOrCreate(['name' => 'pharmacy staff']);
        $pharmacyStaffRole->syncPermissions(['manage transactions']);

        // Assign the admin role to the first user
        $user = User::find(1); // Assuming the user has ID 1
        if ($user && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }

        // Verify role assignment (optional)
        if ($user) {
            $roles = $user->getRoleNames(); // This should list 'admin'
            foreach ($roles as $role) {
                echo "Role: $role\n";
            }
        }
    }
}
