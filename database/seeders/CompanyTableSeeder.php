<?php

namespace Database\Seeders;

use App\Helpers\RolePermissionHelper;
use App\Helpers\AppHelper;
use App\Models\Admin\Company;
use App\Models\Admin\Role;
use App\Models\Admin\User;
use App\Models\Pms\PmsPermission;
use App\Models\Pms\PmsRole;
use App\Models\Pms\PmsUser;
use App\Models\Tenant;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = [
            'name' => 'Logicrays PVT.LTD.',
            'phone_no' => '9876543210',
            'city' => 'Ahmedabad',
            'country' => 'India',
            'status' => '1',
            'subdomain' => 'logicrays'
        ];

        $userData = [
            'name' => 'Tabu Khao',
            'email' => 'example@mailinator.com',
            'password' => bcrypt('Test@123'),
            'status' => '1',
        ];

        try {
            $company = Company::create($company);
            $user = User::create($userData);
            $company->users()->sync([$user->id]);
            Role::create(['name' => 'Customer', 'slug' => 'customer']);
            $user->roles()->attach(RolePermissionHelper::CUSTOMER['id']);

            $tenant = Tenant::create(['id' => 'logicrays']);
            $tenant->domains()->create(['domain' => 'logicrays']);
            $tenant->run(function () use ($userData) {
                PmsRole::create(['name' => 'Owner', 'slug' => 'owner']);
                PmsPermission::insert(RolePermissionHelper::DEFAULT_PERMISSION);

                $pmsUser = PmsUser::create($userData);
                $pmsUser->roles()->attach(RolePermissionHelper::OWNER['id']);

                $permissions = PmsPermission::pluck('id')->toArray();
                $pmsUser->role->permissions()->sync($permissions);
            });
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
