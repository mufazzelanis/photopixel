<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Creates the Super Admin role and makes sure the account's original admin
 * user holds it. Must run AFTER `php artisan shield:generate --all
 * --panel=admin` (that command is what actually creates every per-resource
 * permission) — this seeder only wires the role + admin assignment on top.
 */
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');

        $role = Role::firstOrCreate([
            'name' => $superAdminRole,
            'guard_name' => 'web',
        ]);

        $admin = User::where('email', 'admin@pixelgraphicstudio.com')->first();

        if ($admin && ! $admin->hasRole($role)) {
            $admin->assignRole($role);
        }
    }
}
