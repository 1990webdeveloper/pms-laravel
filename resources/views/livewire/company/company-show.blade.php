@section('title', 'Company')
<div>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18"> {{ $this->companyData->name }}</h4>
                        <div class="my-2 my-sm-0">
                            <a href="{{ route('company.index') }}" class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="company-detail">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Company Information</h4>
                                @php
                                    $compayLogo =
                                        $this->companyData->subdomain . '/profile/logo/' . $this->companyData->logo;
                                @endphp
                                <p class="text-muted mb-4 d-flex align-items-center gap-3">
                                    @if (isset($this->companyData->logo) && s3exist($compayLogo))
                                        <img src="{{ assets3($compayLogo) }}" alt="img"
                                            class="img-thumbnail rounded-circle"
                                            style="width:80px;height:80px;object-fit:contain;">
                                    @else
                                        <img src="{{ asset('assets/images/avatar.png') }}" alt="img"
                                            class="img-thumbnail rounded-circle" style="width:80px;">
                                    @endif
                                </p>
                                <div data-simplebar>
                                    <div class="table-responsive">
                                        <table class="table mb-0 whitespace-nowrap company-info-table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Company:</th>
                                                    <td>{{ $this->companyData->name ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Domain Name :</th>
                                                    <td>{{ $this->companyData->subdomain ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contact Number :</th>
                                                    <td>{{ $this->companyData->phone_no ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Location :</th>
                                                    <td>{{ $this->companyData->city ? $this->companyData->city : '' }}
                                                        {{ $this->companyData->city && $this->companyData->country ? ',' : '' }}
                                                        {{ $this->companyData->country ?? '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Status :</th>
                                                    <td>{{ $this->companyData->status == '1' ? 'Active' : 'inactive' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Owner Information</h4>
                                @php
                                    $avatar =
                                        AppHelper::getUserProfilePath($this->ownerData->uuid) .
                                        '/' .
                                        $this->ownerData->profile;
                                @endphp
                                <p class="text-muted mb-4 d-flex align-items-center gap-3">
                                    @if (isset($this->ownerData->profile) && s3exist($avatar))
                                        <img src="{{ assets3($avatar) }}" alt="img"
                                            class="img-thumbnail rounded-circle"
                                            style="width:80px;height:80px;object-fit:contain">
                                    @else
                                        <img src="{{ asset('assets/images/avatar.png') }}" alt="img"
                                            class="img-thumbnail rounded-circle" style="width:80px;">
                                    @endif
                                </p>
                                <div data-simplebar>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0 company-info-table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Name:</th>
                                                    <td>{{ $this->ownerData['name'] ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Email :</th>
                                                    <td>{{ $this->ownerData['email'] ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contact Number :</th>
                                                    <td>{{ $this->ownerData['phone_no'] ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">DOB</th>
                                                    <td>{{ $this->ownerData['birth_date'] ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Location :</th>
                                                    <td>{{ $this->ownerData['city'] ? $this->ownerData['city'] : '' }}
                                                        {{ $this->ownerData['city'] && $this->ownerData['country'] ? ',' : '' }}
                                                        {{ $this->ownerData['country'] ?? '' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div
                                            class="page-title-box d-sm-flex align-items-center justify-content-between ">
                                            <div
                                                class="d-flex  flex-wrap flex-sm-nowrap align-items-center row-gap-2 column-gap-4">
                                                <h4 class="mb-0 font-size-18">Members List</h4>
                                                <p class="m-0 title-total-user">
                                                    {{ $this->userCount }} Members</p>
                                                <div class="page-search position-relative hide d-sm-flex">
                                                    <input type="search" wire:model.debounce.1000ms="userSearch"
                                                        placeholder="Search..." class="form-control rounded-pill"
                                                        maxlength="256" />
                                                    <i class="bi bi-search position-absolute"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive" data-simplebar>
                                            <table class="table company-list-table company-info-table">
                                                <thead>
                                                    <tr>
                                                        <th>Profile</th>
                                                        <th>Email</th>
                                                        <th>Contact Number</th>
                                                        <th>DOB</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($this->userData as $user)
                                                        <tr>
                                                            <td>
                                                                @php
                                                                    $avatar =
                                                                        AppHelper::getUserProfilePath($user->uuid) .
                                                                        '/' .
                                                                        $user->profile;
                                                                @endphp
                                                                <div class="d-flex align-items-center">
                                                                    @if ($user->profile && s3exist($avatar))
                                                                        <img src="{{ assets3($avatar) }}"
                                                                            class="rounded-circle avatar-table me-2"
                                                                            alt="user-pic">
                                                                    @else
                                                                        <img class="rounded-circle avatar-table me-2"
                                                                            src="{{ asset('/assets/images/avatar.png') }}"
                                                                            alt="Header Avatar">
                                                                    @endif
                                                                    <div class="text-truncate">
                                                                        {{ $user->name }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->phone_no }}</td>
                                                            <td>
                                                                {{ $user->birth_date ? date('m/d/Y', strtotime($user->birth_date)) : '' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-body row">
                                            {{ $this->userData->links('vendor.livewire.bootstrap') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
</div>
