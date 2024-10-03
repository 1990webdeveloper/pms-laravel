@section('title', 'Company')
<div>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between ">
                        <div class="d-flex  flex-wrap flex-sm-nowrap align-items-center row-gap-2 column-gap-4">
                            <h4 class="mb-0 font-size-18">Company List</h4>
                            <p class="m-0 title-total-user">
                                <span class="fw-normal text-white rounded px-2 py-1 fs-14 bg-blue">
                                    {{ $this->companyCount }}</span>
                            </p>
                            <div class="page-search position-relative hide d-sm-flex">
                                <input type="search" wire:model.debounce.1000ms="search" placeholder="Search..."
                                    class="form-control rounded-pill" />
                                <i class="bi bi-search position-absolute"></i>
                            </div>
                        </div>

                        <div class="my-2 my-sm-0">
                            <a href="{{ route('company.createOrEdit') }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i>Add New
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            @if (!blank($this->companyData))
                <div class="company-detail">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card border-0">
                                <div class="card-body min-vh-50 member-list-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive member-list-table member-list-sticky">
                                                <table class="table member-list-table ">
                                                    <thead>
                                                        <tr>
                                                            <th wire:click="sortBy('name')" class="cursor-pointer">
                                                                Company Name
                                                                @if ($this->showSortingIcon && $this->sortBy == 'name')
                                                                    @if ($this->sortDirection == 'asc')
                                                                        <i class="material-icons-outlined fs-7">
                                                                            north</i>
                                                                    @else
                                                                        <i class="material-icons-outlined fs-7">
                                                                            south</i>
                                                                    @endif
                                                                @else
                                                                    <i class="material-icons-outlined fs-6">
                                                                        import_export</i>
                                                                @endif
                                                            </th>
                                                            <th wire:click="sortBy('subdomain')" class="cursor-pointer">
                                                                Domain
                                                                @if ($this->showSortingIcon && $this->sortBy == 'subdomain')
                                                                    @if ($this->sortDirection == 'asc')
                                                                        <i class="material-icons-outlined fs-7">
                                                                            north</i>
                                                                    @else
                                                                        <i class="material-icons-outlined fs-7">
                                                                            south</i>
                                                                    @endif
                                                                @else
                                                                    <i class="material-icons-outlined fs-6">
                                                                        import_export</i>
                                                                @endif
                                                            </th>
                                                            <th wire:click="sortBy('phone_no')" class="cursor-pointer">
                                                                Contact Number
                                                                @if ($this->showSortingIcon && $this->sortBy == 'phone_no')
                                                                    @if ($this->sortDirection == 'asc')
                                                                        <i class="material-icons-outlined fs-7">
                                                                            north</i>
                                                                    @else
                                                                        <i class="material-icons-outlined fs-7">
                                                                            south</i>
                                                                    @endif
                                                                @else
                                                                    <i class="material-icons-outlined fs-6">
                                                                        import_export</i>
                                                                @endif
                                                            </th>
                                                            <th wire:click="sortBy('created_at')"
                                                                class="cursor-pointer">
                                                                Date Of Creation
                                                                @if ($this->showSortingIcon && $this->sortBy == 'created_at')
                                                                    @if ($this->sortDirection == 'asc')
                                                                        <i class="material-icons-outlined fs-7">
                                                                            north</i>
                                                                    @else
                                                                        <i class="material-icons-outlined fs-7">
                                                                            south</i>
                                                                    @endif
                                                                @else
                                                                    <i class="material-icons-outlined fs-6">
                                                                        import_export</i>
                                                                @endif
                                                            </th>
                                                            <th wire:click="sortBy('web_logo_setting')"
                                                                class="cursor-pointer">
                                                                Web Logo setting
                                                                @if ($this->showSortingIcon && $this->sortBy == 'web_logo_setting')
                                                                    @if ($this->sortDirection == 'asc')
                                                                        <i class="material-icons-outlined fs-7">
                                                                            north</i>
                                                                    @else
                                                                        <i class="material-icons-outlined fs-7">
                                                                            south</i>
                                                                    @endif
                                                                @else
                                                                    <i class="material-icons-outlined fs-6">
                                                                        import_export</i>
                                                                @endif
                                                            </th>
                                                            <th wire:click="sortBy('desktop_logo_setting')"
                                                                class="cursor-pointer">
                                                                Desktop Logo setting
                                                                @if ($this->showSortingIcon && $this->sortBy == 'desktop_logo_setting')
                                                                    @if ($this->sortDirection == 'asc')
                                                                        <i class="material-icons-outlined fs-7">
                                                                            north</i>
                                                                    @else
                                                                        <i class="material-icons-outlined fs-7">
                                                                            south</i>
                                                                    @endif
                                                                @else
                                                                    <i class="material-icons-outlined fs-6">
                                                                        import_export</i>
                                                                @endif
                                                            </th>
                                                            <th wire:click="sortBy('status')" class="cursor-pointer">
                                                                Status
                                                                @if ($this->showSortingIcon && $this->sortBy == 'status')
                                                                    @if ($this->sortDirection == 'asc')
                                                                        <i class="material-icons-outlined fs-7">
                                                                            north</i>
                                                                    @else
                                                                        <i class="material-icons-outlined fs-7">
                                                                            south</i>
                                                                    @endif
                                                                @else
                                                                    <i class="material-icons-outlined fs-6">
                                                                        import_export</i>
                                                                @endif
                                                            </th>
                                                            <th wire:click="sortBy('payment_status')"
                                                                class="cursor-pointer">
                                                                Payment Status
                                                                @if ($this->showSortingIcon && $this->sortBy == 'payment_status')
                                                                    @if ($this->sortDirection == 'asc')
                                                                        <i class="material-icons-outlined fs-7">
                                                                            north</i>
                                                                    @else
                                                                        <i class="material-icons-outlined fs-7">
                                                                            south</i>
                                                                    @endif
                                                                @else
                                                                    <i class="material-icons-outlined fs-6">
                                                                        import_export</i>
                                                                @endif
                                                            </th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($this->companyData as $key => $company)
                                                            <tr>
                                                                <td>
                                                                    @php
                                                                        $logo =
                                                                            $company->subdomain .
                                                                            '/profile/logo/' .
                                                                            $company->logo;
                                                                    @endphp
                                                                    <div class="d-flex align-items-center">
                                                                        @if ($company->logo && s3exist($logo))
                                                                            <img src="{{ assets3($logo) }}"
                                                                                alt="profile"
                                                                                class="rounded-circle avatar-table me-2">
                                                                        @else
                                                                            <img src="{{ asset('assets/images/avatar.png') }}"
                                                                                alt="profile"
                                                                                class="rounded-circle avatar-table me-2">
                                                                        @endif
                                                                        <div class="text-truncate">
                                                                            {{ $company->name }}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $company->subdomain }}</td>
                                                                <td>{{ $company->phone_no }}</td>
                                                                <td>{{ date('m/d/Y', strtotime($company->created_at)) }}
                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class="form-check form-switch d-flex px-0 mb-2 mt-2">
                                                                        <x-buttons.toggle :key="$key"
                                                                            wire:click='webLogoSetting({{ $company->id }},$event.target.checked)'
                                                                            data-checked="{{ $company->web_logo_setting === '1' ? true : false }}" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class="form-check form-switch d-flex px-0 mb-2 mt-2">
                                                                        <x-buttons.toggle :key="$key"
                                                                            wire:click='desktopLogoSetting({{ $company->id }},$event.target.checked)'
                                                                            data-checked="{{ $company->desktop_logo_setting === '1' ? true : false }}" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <x-buttons.toggle :key="$key"
                                                                        wire:click='changeStatus({{ $company->id }},$event.target.checked)'
                                                                        data-checked="{{ $company->status === '1' ? true : false }}" />
                                                                </td>
                                                                <td>
                                                                    <x-buttons.toggle :key="$key"
                                                                        wire:click='changePaymentStatus({{ $company->id }},$event.target.checked)'
                                                                        data-checked="{{ $company->payment_status === '1' ? true : false }}" />
                                                                </td>
                                                                <td>
                                                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                                                        <li>
                                                                            <a href="{{ route('company.show', $company->id) }}"
                                                                                class="btn btn-sm">
                                                                                <i class="bi bi-eye fs-5"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('company.createOrEdit', $company->id) }}"
                                                                                class="btn btn-sm">
                                                                                <i
                                                                                    class="material-icons-outlined fs-4">edit</i>
                                                                            </a>
                                                                        </li>
                                                                        <li>

                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-center">
                                                    <x-except-loader />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row p-5">
                    <div class="col-sm-12">
                        <div class="text-center no_data calc-height">
                            <div class=" d-flex flex-column justify-content-center align-items-center p-2">
                                <div
                                    class="min-vh-320 no-content-outer d-flex flex-column justify-content-center align-items-center">
                                    <img class="me-2 no-record-img" src="{{ asset('/assets/images/no-content.png') }}"
                                        alt="Avatar">

                                    No Data Found
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- container-fluid -->
    </div>
</div>
@push('scripts')
    <script>
        var loadedAllData = false;

        Livewire.on('loadedAllData', () => {
            loadedAllData = true;
        });
        let scrolling = false;
        let lastScrollTop = 0;

        Livewire.on('initialRecordLoad', () => {
            $('.member-list-table').scroll(function() {
                console.log("list table");
                let st = $(this).scrollTop();
                let newst = st + 2;
                let scrollingDown = newst > lastScrollTop;
                lastScrollTop = st;
                let thisvar = $(this);
                // Your existing code
                clearTimeout($(this).data('scrollEndTimeout'));
                $(this).data('scrollEndTimeout', setTimeout(() => {
                    let scrollHeight = thisvar.prop('scrollHeight');
                    let innerHeight = thisvar.innerHeight();
                    let scrollTop = thisvar.scrollTop();
                    let distanceToBottom = scrollHeight - (innerHeight + scrollTop);
                    console.log(scrollingDown, distanceToBottom, loadedAllData);
                    if (scrollingDown && distanceToBottom < 80 && !loadedAllData) {
                        console.log('Scrolling down, loadMore');
                        Livewire.emit("loadMore");
                    }
                }, 200));
            });
        });


        window.addEventListener('DOMContentLoaded', (event) => {
            Livewire.emit('loadInitial', Math.floor(window.innerHeight / 60));
        });

        Livewire.on('allRecordsLoaded', () => {
            console.log("stop loader");
        });
    </script>
@endpush
