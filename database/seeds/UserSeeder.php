<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('superadmin')
        ]);

        $roles = ['super admin', 'project manager', 'employee'];

        foreach ($roles as $value) {
            $role = Role::create(['name'=> $value]);
        }

        $permissions = ['create job', 'update job', 'delete job', 'create new departement'];

        foreach ($permissions as $value) {
            $permission = Permission::create(['name' => $value]);
        }

        $user->assignRole('super admin');
    }
}
