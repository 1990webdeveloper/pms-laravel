@section('title', 'Company Create')
<div>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18"> {{ $this->companyData ? 'Edit Company' : 'Add Company' }}
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="card border-0 p-3">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div>
                            <form class="profile-form mt-1" id="companyForm">
                                <h6 class="bg-soft bg-primary text-primary p-2 rounded fw-semibold mb-4">
                                    Company details</h6>

                                <div class="mb-4">
                                    <label class="form-label">Company Name<span
                                            class="fs-5 text-danger lh-1">*</span></label>
                                    <input type="text" name="company_name" class="form-control"
                                        placeholder="Enter Company Name" maxlength="30" minlength="3"
                                        wire:model.lazy="company.name" required>
                                    @error('company.name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Domain Name<span
                                            class="fs-5 text-danger lh-1">*</span></label>
                                    <input type="text" value="" name="subdomain" class="form-control"
                                        placeholder="Enter Domain Name" onkeydown="return /[a-z0-9]/i.test(event.key)"
                                        maxlength="30" minlength="2" wire:model.lazy="company.subdomain"
                                        @if ($this->companyData) disabled @endif required>
                                    @error('company.subdomain')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                              
                                <div class="mb-4">
                                    <label class="form-label">Phone Number<span
                                            class="fs-5 text-danger lh-1">*</span></label>
                                    <input type="number" value="" name="company_phone_no" class="form-control"
                                        placeholder="Enter Phone Number" maxlength="10" minlength="10"
                                        wire:model.lazy="company.phone_no" required>
                                    @error('company.phone_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Country</label>
                                    <x-select2 class="form-control" wire:model="company.country" name="company_country">
                                        <option value="">Select Country</option>
                                        @foreach ($this->country as $cval)
                                            <option value="{{ $cval['code'] }}">{{ $cval['name'] }}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('company.country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" value="" name="company_city" maxlength="30"
                                        minlength="3" wire:model.lazy="company.city" class="form-control"
                                        placeholder="Enter City Name">
                                    @error('company.city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div>
                            <form class="profile-form mt-1" id="ownerForm">
                                <h6 class="bg-soft bg-primary text-primary p-2 rounded fw-semibold mb-4">Owner details</h6>
                                <div class="mb-4">
                                    <label class="form-label">Owner Name<span
                                            class="fs-5 text-danger lh-1">*</span></label>
                                    <input type="text" value="" name="owner_name" class="form-control"
                                        placeholder="Enter Owner Name" maxlength="30" minlength="3"
                                        wire:model.lazy="owner.name" @if ($this->companyData) disabled @endif required>
                                    @error('owner.name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Email Address<span
                                            class="fs-5 text-danger lh-1">*</span></label>
                                    <input type="email" value="" name="email" class="form-control"
                                        placeholder="Enter Owner Email Address" wire:model.lazy="owner.email" maxlength="320"
                                        @if ($this->companyData) disabled @endif required>
                                    @error('owner.email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Phone Number<span
                                            class="fs-5 text-danger lh-1">*</span></label>
                                    <input type="number" value="" name="owner_phone_no" class="form-control"
                                        placeholder="Enter Owner Phone Number" maxlength="10" minlength="10"
                                        wire:model.lazy="owner.phone_no" required>
                                    @error('owner.phone_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Country</label>
                                    <x-select2 class="form-control" wire:model="owner.country" name="owner_country">
                                        <option value="">Select Country</option>
                                        @foreach ($this->country as $cval)
                                            <option value="{{ $cval['code'] }}">{{ $cval['name'] }}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('owner.country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" value="" name="owner_city"
                                        placeholder="Enter Owner City Name" class="form-control" maxlength="30"
                                        minlength="3" wire:model.lazy="owner.city">
                                    @error('owner.city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col">
                                    <label class="form-label">Birthday</label>
                                    <x-input.datepicker wire:model="owner.birth_date"
                                        minDate="{{ $this->minBirthDate }}" maxDate="{{ $this->maxBirthDate }}"
                                        mode="single" placeholder="Enter Birthdate" />
                                    @error('owner.birth_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end align-items-center gap-3 mt-4 mb-3">
                                    <a class="btn btn-primary" wire:loading.class='disable-button' wire:click.prevent='registerCompany'>
                                        <div wire:loading wire:target="registerCompany" class="spinner-border text-white spinner-button"
                                            role="status" aria-hidden="true">
                                        </div>
                                        <div wire:loading.remove wire:target="registerCompany">Save changes
                                        </div>
                                    </a>
                                    <button class="btn btn-cancel" class="reset-btn"
                                        wire:click.prevent="resetFullForm">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
