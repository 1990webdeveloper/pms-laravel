<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pms\RolePermissionController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Member\MemberList;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Company\CompanyCreate;
use App\Http\Livewire\Company\CompanyList;
use App\Http\Livewire\Company\CompanyShow;
use App\Http\Livewire\Permission\PermissionCreate;
use App\Http\Livewire\Permission\PermissionList;
use App\Http\Livewire\Role\RoleCreate;
use App\Http\Livewire\Role\RoleList;
use App\Http\Livewire\RolePermission\EditRolePermission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    Route::get('/logout', [DashboardController::class, 'destroy'])->name('logout');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('user.profile');

    /**Company Management */
    Route::get('/company', CompanyList::class)->name('company.index');
    Route::get('/company/create/{id?}', CompanyCreate::class)->name('company.createOrEdit');
    Route::get('/company/show/{id?}', CompanyShow::class)->name('company.show');

    /**Role Management */
    Route::get('/role', RoleList::class)->name('role');
    Route::get('/role/create-edit/{id?}', RoleCreate::class)->name('role.createOrEdit');

    /**Permission Management */
    Route::get('/permission', PermissionList::class)->name('permission');
    Route::get('/permission/create-edit/{id?}', PermissionCreate::class)->name('permission.createOrEdit');

    /**Role Permission Management */
    Route::get('/role-permission', RoleList::class)->name('role-permission');
    Route::get('/role-permission/edit/{id?}', EditRolePermission::class)->name('role-permission.edit');

    Route::get('/members', MemberList::class)->name('member.index');
});
