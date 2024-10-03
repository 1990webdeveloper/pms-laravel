<?php

namespace Database\Seeders;

use App\Helpers\RolePermissionHelper;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Database\Seeder;
use App\Models\Admin\User;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Jhon Disosa',
            'email' => 'jhon@mailinator.com',
            'password' => bcrypt('Test@123'),
            'status' => '1',
            'email_verified_at' => \Carbon\Carbon::now(),
            'remember_token' => Str::random(10),
        ];

        $user = User::create($user);
        $role = Role::create(RolePermissionHelper::ADMIN);
        Permission::insert(RolePermissionHelper::DEFAULT_PERMISSION);
        $user->roles()->attach($role);
        $permissions = Permission::pluck('id')->toArray();
        $role->permissions()->sync($permissions);
    }
}
