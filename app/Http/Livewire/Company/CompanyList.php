<?php

namespace App\Http\Livewire\Company;

use App\Helpers\AppHelper;
use App\Http\Livewire\Modals\DeleteModal;
use App\Jobs\UserLogData;
use App\Models\Admin\Company;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Livewire\WithPagination;
use Livewire\Component;

class CompanyList extends Component
{
    use WithPagination;

    public $status;
    public $search;
    public $showSortingIcon = false;
    public $sortDirection = 'asc';
    public $sortBy = 'name';
    public $companyData;
    public $loadRecordCount = 0;
    public $companyCount = 0;
    public $isLoaderOn = true;
    public $firstTimeLoad = true;
    public $ip;
    public $serverDetail;

    protected $listeners = [
        'closeDeleteModal',
        'loadInitial',
        'loadMore',
    ];

    /**
     * Mount the data
     */
    public function mount()
    {
        $this->ip = Request::ip();
        $this->serverDetail = Request::server();
        // $this->getData();
    }

    /**
     * Initial load some position data
     */
    public function loadInitial($take)
    {
        $this->isLoaderOn  =  false;
        $this->loadRecordCount = 20;
        $this->getCompanyData(take: 20);
        $this->firstTimeLoad = false;
        $this->emit('initialRecordLoad');
    }

    /**
     * Load more member data
     */
    public function loadMore()
    {
        $count = $this->companyData->count();
        if ($this->companyCount == $count) {
            $this->emit('loadedAllData');
            return;
        }
        $this->getCompanyData();
    }

    public function getCompanyData($take = 20, $isFresh = false)
    {
        $companyList = Company::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection);
        $countQuery = $companyList;
        $this->companyCount = $countQuery->count();
        $skip = $this->companyData?->count() ?? 0;
        $takeRecords = $take;

        $newRecords = $companyList->orderBy($this->sortBy, $this->sortDirection);
        if (!$isFresh) {
            $newRecords->skip($skip);
        } else {
            $takeRecords = $skip;
        }

        $newRecords = $newRecords->take($takeRecords)->get();

        if ($isFresh) {
            $this->companyData = $newRecords->fresh();
        } else {
            if (!blank($this->companyData)) {
                $this->companyData = $this->companyData->concat($newRecords);
            } else {
                $this->companyData = $newRecords;
            }
        }
    }

    /**
     * Active/inactive company
     */
    public function changeStatus($companyId, $status)
    {
        try {
            $status = ($status == true) ? "1" : "0";
            Company::where('id', $companyId)->update(['status' => $status]);

            //Log user activity
            dispatch(new UserLogData(
                "Company",
                'Company list : Status change',
                $this->userInfo->id,
                $this->ip,
                $this->serverDetail,
                [
                    'id' => $companyId,
                    'status' => $status,
                ]
            ));

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Status updated successfully.'
            ]);
            $this->getCompanyData(take: $this->loadRecordCount, isFresh: true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Status has been not updated.'
            ]);
        }
    }
    /**
     * Active/inactive company payment
     */
    public function changePaymentStatus($companyId, $payment_status)
    {
        try {
            $payment_status = ($payment_status == true) ? "1" : "0";
            Company::where('id', $companyId)->update(['payment_status' => $payment_status]);

            //Log user activity
            dispatch(new UserLogData(
                "Company",
                'Company list : Payment status change',
                $this->userInfo->id,
                $this->ip,
                $this->serverDetail,
                [
                    'id' => $companyId,
                    'payment_status' => $payment_status,
                ]
            ));

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Payment status updated successfully.'
            ]);
            $this->getCompanyData(take: $this->loadRecordCount, isFresh: true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Payment status has been not updated.'
            ]);
        }
    }
    /**
     * Get company data
     */
    public function getData()
    {
        foreach ($this->companyData as $company) {
            $this->status[$company->id] = (bool)$company->status;
        }
    }
    /**
     * Sort the data by the given column.
     *
     * @param  string  $column
     * @return void
     */
    public function sortBy($column)
    {
        $this->showSortingIcon = true;
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->getCompanyData(take: $this->loadRecordCount, isFresh: true);
    }
    /**
     * Web Logo setting enable/disable
     */
    public function webLogoSetting($companyId, $value)
    {
        try {
            Company::where('id', $companyId)->update(['web_logo_setting' => $value ? '1' : '0']);

            //Log user activity
            dispatch(new UserLogData(
                "Company",
                'Company list : Web logo change',
                $this->userInfo->id,
                $this->ip,
                $this->serverDetail,
                [
                    'id' => $companyId,
                    'web_logo_setting' => $value ? '1' : '0',
                ]
            ));

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Web logo setting updated successfully.'
            ]);
            $this->getCompanyData(take: $this->loadRecordCount, isFresh: true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Data has been not updated.'
            ]);
        }
    }
    /**
     * DEsktop Logo setting enable/disable
     */
    public function desktopLogoSetting($companyId, $value)
    {
        try {
            Company::where('id', $companyId)->update(['desktop_logo_setting' => $value ? '1' : '0']);

            //Log user activity
            dispatch(new UserLogData(
                "Company",
                'Company list : Desktop logo change',
                $this->userInfo->id,
                $this->ip,
                $this->serverDetail,
                [
                    'id' => $companyId,
                    'desktop_logo_setting' => $value ? '1' : '0',
                ]
            ));

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'DEsktop logo setting updated successfully.'
            ]);
            $this->getCompanyData(take: $this->loadRecordCount, isFresh: true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Data has been not updated.'
            ]);
        }
    }
    /**
     * Delete company
     */
    public function delete($sourceId)
    {
        $this->emit('openModal', DeleteModal::getName(), ["sourceId" => $sourceId, 'table' => 'pms_company']);
    }
    /**
     * Close delete modal
     */
    public function closeDeleteModal()
    {
        $this->companyData->fresh();
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
        return view('livewire.company.company-list');
    }
}
