<?php

namespace App\Http\Livewire\Company;

use App\Actions\Admin\CompanyRegisterAction;
use App\Helpers\RolePermissionHelper;
use App\Helpers\AppHelper;
use App\Jobs\UserLogData;
use App\Models\Admin\Company;
use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;
use App\Mail\WorkspaceCreate;
use App\Models\Admin\User;
use App\Models\CentralDatabaseCountry;
use App\Models\Pms\PmsAttendance;
use App\Models\Pms\PmsPermission;
use App\Models\Pms\PmsRole;
use App\Models\Pms\PmsSettings;
use App\Models\Pms\PmsStatus;
use App\Models\Pms\PmsUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class CompanyCreate extends Component
{
    use WithFileUploads;

    public $companyId;
    public $company;
    public $owner;
    public $minBirthDate;
    public $maxBirthDate;
    public $ip;
    public $serverDetail;
    protected $listeners = ['changeDate'];

    /**
     * Mount the data
     */
    public function mount()
    {
        $this->companyId = request()->id;
        $this->minBirthDate = Carbon::now()->subYears('80')->toDateString();
        $this->maxBirthDate = Carbon::now()->subYears('15')->toDateString();
        $this->ip = Request::ip();
        $this->serverDetail = Request::server();
        $this->setCompanyData();
        $this->setUserData();
    }

    /**
     * Get one company data property.
     */
    public function getCompanyDataProperty()
    {
        return Company::find($this->companyId);
    }

    /**
     * Set the company data for edit page use
     */
    public function setCompanyData()
    {
        if ($this->companyData) {
            $this->company = $this->companyData->toArray();
        } else {
            $this->company = [
                'country' => ''
            ];
        }
    }

    /**
     * Set the user data for edit page use
     */
    public function setUserData()
    {
        if ($this->pmsUser) {
            $this->owner = $this->pmsUser;
        } else {
            $this->owner = [
                'birth_date' => '',
                'country' => ''
            ];
        }
    }

    /**
     * Get tenant data
     */
    public function getTenantProperty()
    {
        return Tenant::find($this->companyData->subdomain);
    }

    /**
     * Get pms user data
     */
    public function getPmsUserProperty()
    {
        if ($this->companyData) {
            return $this->tenant->run(function () {
                $user = PmsUser::first();
                if ($user) {
                    return $user->toArray();
                }
            });
        }
    }

    /**
     * Get user data
     */
    public function getUserProperty()
    {
        if ($this->companyData) {
            return User::where('email', isset($this->pmsUser['email']) ? $this->pmsUser['email'] : '')->first();
        }
        return null;
    }

    /**
     *
     * This computed property retrieves and returns the country based on a specific data.
     *
     * @return mixed The country.
     */
    public function getCountryProperty()
    {
        return CentralDatabaseCountry::get(['name', 'code'])->toArray();
    }
    /**
     * Get selected birth date
     */
    public function changeDate($date)
    {
        $this->owner['birth_date'] = $date;
    }

    /**
     * Reset the full form data to its initial state.
     */
    public function resetFullForm()
    {
        $this->company = "";
        $this->owner = "";
        $this->setCompanyData();
        $this->setUserData();
        $this->resetErrorBag();
    }

    /**
     * Register Company
     * Validation check
     */
    public function registerCompany()
    {
        $this->validate(
            array_merge($this->companyRules(), $this->ownerRules()),
            array_merge($this->companyRuleMessage(), $this->ownerRuleMessage())
        );
        $this->store();
    }

    /**
     * Get the validation rules for the company information.
     *
     * @return array
     */
    public function companyRules()
    {
        return collect(Company::getCreateValidationRule((isset($this->company)) ? $this->company : ''))
            ->mapWithKeys(
                fn($item, $key) => ['company.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules message for the company information.
     *
     * @return array
     */
    public function companyRuleMessage()
    {
        return collect(Company::getCreateValidationMessage())
            ->mapWithKeys(
                fn($item, $key) => ['company.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules for the owner information.
     *
     * @return array
     */
    public function ownerRules()
    {
        return collect(User::getCreateValidationRule($this->user->id ?? ''))
            ->mapWithKeys(
                fn($item, $key) => ['owner.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules message for the owner information.
     *
     * @return array
     */
    public function ownerRuleMessage()
    {
        return collect(User::getCreateValidationMessage())
            ->mapWithKeys(
                fn($item, $key) => ['owner.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Company create
     * Tenant/domain create
     * New db create for subdomain
     * Owner/customer creation on central and domain specific user table
     * default role and permission addition to user
     *
     * @return mixed
     */
    public function store()
    {
        try {
            $domainName = Str::slug($this->company['subdomain']);
            $this->company['subdomain'] = $domainName;
            $this->company['country'] = isset($this->company['country']['value']) ? $this->company['country']['value']
                : $this->company['country'];

            if ($this->companyData) {
                unset($this->company['subdomain']);
            }

            if (!$this->companyData) {
                $this->company['status'] = "0";
            }

            //company store
            /** @var CompanyRegisterAction $action */
            $action = app(CompanyRegisterAction::class);
            $company = $action->execute($this->company, $domainName, $this->companyData);

            if (isset($this->owner['birth_date'])) {
                $this->owner['birth_date'] = \Carbon\Carbon::parse($this->owner['birth_date'])->format('Y-m-d');
            }

            if (!$this->companyData) {
                $password = Str::random(8);
                $this->owner['password'] = Hash::make($password);
            }
            $this->owner['status'] = '1';
            $token = base64_encode($this->owner['email']);

            $user = User::updateOrCreate(['email' => $this->pmsUser ? $this->pmsUser['email'] : null], $this->owner);
            if (!$this->companyData) {
                $company->users()->sync([$user->id]);
                $user->roles()->sync([RolePermissionHelper::CUSTOMER['id']]);
            }
            $companyData = $this->companyData;
            //owner store
            $tenant = Tenant::find($domainName);
            $pmsUserTenant = $tenant->run(function () use ($companyData) {
                // $roleExist = PmsRole::where('slug', RolePermissionHelper::OWNER['slug'])->first();
                if (!$companyData) {
                    PmsRole::insert(RolePermissionHelper::DEFAULT_ROLE);
                    PmsPermission::insert(RolePermissionHelper::DEFAULT_PERMISSION);
                    PmsStatus::insert(AppHelper::TASK_STATUS);
                    PmsSettings::insert(AppHelper::SETTINGS);

                    $attendanceId = PmsAttendance::insertGetId(AppHelper::ATTENDANCE_SETTINGS);
                    PmsAttendance::find($attendanceId)->update(['days' => AppHelper::DAYS]);
                }

                $pmsUser = PmsUser::updateOrCreate(['id' => $this->owner['id'] ?? null], $this->owner);
                $pmsUser->roles()->sync([RolePermissionHelper::OWNER['id']]);

                // Assign Owner Permissions
                $ownerPermissions = PmsPermission::whereIn('slug', RolePermissionHelper::OWNER_PERMISSION)
                    ->pluck('id');
                $pmsUser->role->permissions()->sync($ownerPermissions);

                // Executive Manager role assign it's permissions
                $em = PmsRole::where('slug', RolePermissionHelper::EXECUTIVE_MANAGER['slug'])->first();
                $emPermission = PmsPermission::whereIn('slug', RolePermissionHelper::EXECUTIVE_MANAGER_PERMISSION)
                    ->pluck('id');
                $em->permissions()->sync($emPermission);

                // Project Manager role assign it's permissions
                $pm = PmsRole::where('slug', RolePermissionHelper::PROJECT_MANAGER['slug'])->first();
                $pmPermission = PmsPermission::whereIn('slug', RolePermissionHelper::PROJECT_MANAGER_PERMISSION)
                    ->pluck('id');
                $pm->permissions()->sync($pmPermission);

                // Employee role assign it's permissions
                $ep = PmsRole::where('slug', RolePermissionHelper::EMPLOYEE['slug'])->first();
                $epPermission = PmsPermission::whereIn('slug', RolePermissionHelper::EMPLOYEE_PERMISSION)
                    ->pluck('id');
                $ep->permissions()->sync($epPermission);

                // Project viewer role assign it's permissions
                $pw = PmsRole::where('slug', RolePermissionHelper::PROJECT_VIEWER['slug'])->first();
                $pwPermission = PmsPermission::whereIn('slug', RolePermissionHelper::PROJECT_VIEWER_PERMISSION)
                    ->pluck('id');
                $pw->permissions()->sync($pwPermission);

                return $pmsUser;
            });
            User::where('email', $this->owner['email'])->update(['uuid' => $pmsUserTenant->uuid]);
            if (!$this->companyData) {
                $mailData = [];
                $mailData['name'] = $this->owner['name'];
                $mailData['email'] = $this->owner['email'];
                $mailData['password'] = $password;

                Mail::to($this->owner['email'])->send(new WelcomeEmail($mailData, $domainName, $token));
                Mail::to($this->owner['email'])->send(new WorkspaceCreate($mailData, $domainName));
            }

            $retMst = ($this->companyId) ? 'Company Edit' : 'Company registered';
            dispatch(new UserLogData(
                "Company",
                $retMst,
                $this->userInfo->id,
                $this->ip,
                $this->serverDetail,
                [
                    'company' => $this->company,
                    'owner' => $this->owner,
                ]
            ));

            if ($this->companyId) {
                return redirect()->route('company.index')->with('success', 'Company has been updated successfully!!');
            } else {
                return redirect()->route('company.index')->with('success', 'Company has been registered!!');
            }
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()->back()->with('success', 'Company has been not registered!!');
        }
    }

    /**
     *
     * This computed property retrieves and returns the user information based on a specific data.
     *
     * @return mixed The user information.
     */
    public function getUserInfoProperty()
    {
        return AppHelper::getLoginUser();
    }

    /**
     * Render the live-wire component
     *
     *  @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.company.company-create');
    }
}
