<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class AssignAdminRole extends Command
{
    protected $signature = 'user:assign-admin-role {userId}';

    protected $description = 'Assign admin role to a user by ID';

    public function handle()
    {
        $userId = $this->argument('userId');
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->error('Admin role not found.');
            return;
        }

        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found.');
            return;
        }

        $user->role_id = $adminRole->id;
        $user->save();

        $this->info('Admin role assigned successfully to user.');
    }
}
