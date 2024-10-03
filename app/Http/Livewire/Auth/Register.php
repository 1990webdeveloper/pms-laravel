<?php

namespace App\Http\Livewire\Auth;

use App\Actions\Admin\CompanyRegisterAction;
use App\Helpers\RolePermissionHelper;
use App\Mail\WelcomeEmail;
use App\Models\Admin\User;
use App\Models\Pms\PmsPermission;
use App\Models\Pms\PmsRole;
use App\Models\Pms\PmsUser;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Register extends Component
{
    public $register;
    public $password;
    public $confirm_password;

    /**
     * Handle a registration request.
     */
    public function registerSubmit()
    {
        $test = [
            'password' => 'required|string|min:6',
            'confirm_password' => 'same:password'
        ];
        $this->validate(
            array_merge($this->registerRules(), $test),
            $this->registerRuleMessage()
        );
        try {
            $userArr = [
                'name' => $this->register['fname'] . ' ' . $this->register['lname'],
                'email' => $this->register['email'],
                'password' => Hash::make($this->password),
                'status' => '1'
            ];
            $domainName = strtolower($this->register['subdomain']);
            $company = [
                'name' => $this->register['fname'] . ' ' . $this->register['lname'],
                'email' => $this->register['email'],
                'subdomain' => $domainName,
                'status' => '1'
            ];

            $user = User::create($userArr);
            $user->roles()->attach(RolePermissionHelper::CUSTOMER['id']);


            /** @var CompanyRegisterAction $action */
            $action = app(CompanyRegisterAction::class);
            $company = $action->execute($company, $domainName);

            $tenant = Tenant::find($domainName);
            $tenant->run(function () use ($userArr) {
                $roleExist = PmsRole::where('slug', RolePermissionHelper::OWNER['slug'])->first();
                if (!isset($roleExist)) {
                    PmsRole::create(['name' => 'Owner', 'slug' => 'owner']);
                }
                PmsPermission::insert(RolePermissionHelper::DEFAULT_PERMISSION);

                $pmsUser = PmsUser::create($userArr);

                $pmsUser->roles()->sync([RolePermissionHelper::OWNER['id']]);

                $permissions = PmsPermission::pluck('id')->toArray();
                $pmsUser->role->permissions()->sync($permissions);
            });

            $company->users()->sync([$user->id]);

            $mailData = [];
            $mailData['name'] = $user->name;
            $mailData['email'] = $user->email;

            Mail::to($mailData['email'])->send(new WelcomeEmail($mailData, $domainName));

            return redirect()->route('register')->with('success', 'Register successfully, Please check your email');
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'Something went wrong while registering');
        }
    }

    /**
     * Get the validation rules for the owner information.
     *
     * @return array
     */
    public function registerRules()
    {
        return collect(PmsUser::getRegisterValidationRule())
            ->mapWithKeys(
                fn ($item, $key) => ['register.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules message for the owner information.
     *
     * @return array
     */
    public function registerRuleMessage()
    {
        return collect(PmsUser::getRegisterValidationMessage())
            ->mapWithKeys(
                fn ($item, $key) => ['register.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Render the component's view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.auth');
    }
}
