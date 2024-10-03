<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain;
use App\Http\Controllers\Pms\ScreenShotController;
use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Member\InviteUserRegister;
use App\Http\Livewire\Member\MemberList;
use App\Http\Livewire\Permission\PermissionCreate;
use App\Http\Livewire\Permission\PermissionList;
use App\Http\Livewire\Position\PositionCreate;
use App\Http\Livewire\Position\PositionList;
use App\Http\Livewire\Project\ProjectAdd;
use App\Http\Livewire\Project\ProjectList;
use App\Http\Livewire\Role\RoleCreate;
use App\Http\Livewire\Role\RoleList;
use App\Http\Livewire\RolePermission\EditRolePermission;
use App\Http\Livewire\Task\TaskEdit;
use App\Http\Livewire\Task\TaskList;
use App\Http\Livewire\Team\TeamList;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    'universal',
    InitializeTenancyByDomainOrSubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
    Route::group(['middleware' => ['guest:pms_user']], function () {
        Route::get('/login', Login::class)->name('login');
        Route::get('/forgot-password', ForgotPassword::class)->name('forgot.password');
        Route::get('/user/reset-password/{token?}', ResetPassword::class)->name('reset.password');
        Route::get('/invitation/{token?}', InviteUserRegister::class)->name('invitation.index');
    });

    Route::group(['middleware' => ['auth:pms_user', 'user.log']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

        Route::get('/logout', [DashboardController::class, 'destroy'])->name('logout');

        Route::get('/profile', [DashboardController::class, 'profile'])->name('user.profile');

        Route::get('/role', RoleList::class)->name('role');
        Route::get('/role/create-edit/{id?}', RoleCreate::class)->name('role.createOrEdit');

        Route::get('/permission', PermissionList::class)->name('permission');
        Route::get('/permission/create-edit/{id?}', PermissionCreate::class)->name('permission.createOrEdit');

        Route::get('/role-permission', RoleList::class)->name('role-permission');
        Route::get('/role-permission/edit/{id?}', EditRolePermission::class)->name('role-permission.edit');

        Route::get('/position', PositionList::class)->name('position.index');
        Route::get('/position/create-edit/{id?}', PositionCreate::class)->name('position.createOrEdit');

        Route::get('/members', MemberList::class)->name('member.index');

        Route::get('/teams', TeamList::class)->name('team.index');

        Route::get('/projects', ProjectList::class)->name('project.index');
        Route::get('/project/create', ProjectAdd::class)->name('project.create');

        Route::get('/tasks', TaskList::class)->name('task.index');
        Route::get('/task/edit/{id?}', TaskEdit::class)->name('task.edit');

        Route::get('/screenshot', [ScreenShotController::class, 'index'])->name('screenshot.index');
    });
});
