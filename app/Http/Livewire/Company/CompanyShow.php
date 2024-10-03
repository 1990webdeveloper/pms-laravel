<?php

namespace App\Http\Livewire\Company;

use App\Helpers\RolePermissionHelper;
use App\Models\Admin\Company;
use App\Models\Pms\PmsRole;
use App\Models\Pms\PmsUser;
use App\Models\Tenant;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyShow extends Component
{
    use WithPagination;

    public $companyId;
    public $userSearch;

    /**
     * Mount the data
     */
    public function mount()
    {
        $this->companyId = request()->id;
    }
    /**
     * Get one company data property.
     */
    public function getCompanyDataProperty()
    {
        $company = Company::find($this->companyId);
        if (!$company) {
            return abort(404);
        }
        return $company;
    }
    /**
     * Get tenant data
     */
    public function getTenantProperty()
    {
        return Tenant::find($this->companyData->subdomain);
    }
    /**
     * Get one owner data property.
     */
    public function getOwnerDataProperty()
    {
        if ($this->tenant) {
            return $this->tenant->run(function () {
                $users = PmsRole::where('slug', RolePermissionHelper::OWNER['slug'])->first()->users->first();
                return $users;
            });
        } else {
            return abort(500);
        }
    }
    /**
     * Get all users data property.
     */
    public function getUserDataProperty()
    {
        $userData = $this->tenant->run(function () {
            $users = PmsUser::where('name', 'like', '%' . $this->userSearch . '%');
            $users = $users->paginate(10);

            return $users;
        });
        return $userData;
    }
    public function getUserCountProperty()
    {
        $userData = $this->tenant->run(function () {
            $users = PmsUser::count();

            return $users;
        });
        return $userData;
    }
    public function render()
    {
        return view('livewire.company.company-show');
    }
}
