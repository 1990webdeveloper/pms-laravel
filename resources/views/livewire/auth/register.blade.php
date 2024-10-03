@section('title', 'SignUp')

<div class="auth-wrapper">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-md-6 col-lg-6 col-xl-8">
                <div class="d-none d-sm-none d-md-block auth-signup-bg auth-full-bg h-100vh">
                    <div class="h-100">
                        <div class="bg-overlay"></div>
                        <div class="d-flex h-100 flex-column justify-content-center">
                            <div class="">
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                        <div class="text-center">
                                            <img class="d-block w-75 m-auto mover" src="./assets/images/sign-up.svg"
                                                alt="slider-1" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="auth-full-page-content d-flex h-100vh p-md-4 p-lg-5 p-4 overflow-y-auto justify-content-center"
                    data-simplebar>
                    <div class="w-100 h-100">
                        <div class="d-flex flex-column h-100">
                            <div class="my-auto">
                                <div class="mb-4 mb-md-5">
                                    <div class="d-block text-center auth-logo mb-5">
                                        <img src="{{ asset('/assets/images/logo.svg') }}" alt="logo">
                                    </div>
                                    <h3 class="text-center mt-3 fw-semibold">Get Started</h3>
                                    <p class="text-muted text-center fw-normal mt-0">Create your account now</p>
                                </div>

                                <div class="mt-4">
                                    <form class="form-horizontal">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="First Name"
                                                name="fname" value="" wire:model.lazy="register.fname" required
                                                autofocus>
                                            @error('register.fname')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Last Name"
                                                name="lname" value="" wire:model.lazy="register.lname" required>
                                            @error('register.lname')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Domain Name"
                                                name="subdomain" value="" wire:model.lazy="register.subdomain"
                                                required>
                                            @error('register.subdomain')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email"
                                                name="email" value="" wire:model.lazy="register.email" required>
                                            @error('register.email')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control " id="password"
                                                    placeholder="Password" name="password" wire:model.lazy="password"
                                                    required>
                                                <i class="toggle-password bi bi-eye-slash eye-icon"></i>
                                            </div>
                                            @error('password')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control " id="confirm_password"
                                                    placeholder="Confirm Password" name="confirm_password"
                                                    wire:model.lazy="confirm_password" required>
                                                <i class="toggle-password bi bi-eye-slash eye-icon"></i>
                                            </div>
                                            @error('confirm_password')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mt-4 d-grid">
                                            <a class="btn btn-primary waves-effect waves-light"
                                                wire:loading.class='disable-button' wire:click.prevent='registerSubmit'>
                                                <div wire:loading wire:target="registerSubmit"
                                                    class="spinner-border text-primary spinner-button" role="status"
                                                    aria-hidden="true">
                                                </div>
                                                <div wire:loading.remove wire:target="registerSubmit">Register</div>
                                            </a>
                                        </div>
                                        <p class=" text-muted d-block mt-5 p-0 text-center">
                                            Already have an account<a href="{{ route('login') }}"
                                                class="ps-2 btn-link">Login</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
    </div>
</div>
