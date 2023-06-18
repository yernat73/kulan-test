<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        Artisan::call('shield:generate', [
            '--option' => 'permissions',
            '--all' => true,
        ]);

        Role::query()
            ->create([
                'name' => 'user',
                'guard_name' => 'web',
            ])
            ->givePermissionTo([
                'create_delivery',
                'view_any_delivery',
                'view_city',
                'view_any_city',
            ]);

        Role::query()
            ->where('name', 'super_admin')
            ->firstOrFail()
            ->users()
            ->create([
                'name' => 'Admin',
                'email' => 'admin@kulan.kz',
                'password' => Hash::make('123456789'),
            ]);
    }
}
