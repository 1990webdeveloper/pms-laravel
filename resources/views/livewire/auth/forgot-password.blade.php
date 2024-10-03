@section('title', 'Forgot Password')
<div>
    <div class="auth-wrapper">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="auth-full-page-content d-flex h-100vh p-md-4 p-lg-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="my-auto">
                                    <div class="mb-4 mb-md-5">
                                        <div class="d-block text-center auth-logo mb-5">
                                            <img src="{{ asset('/assets/images/logo.svg') }}" alt="logo">
                                        </div>
                                        <h3 class="text-center mt-3">Forgot Password!</h3>
                                        <p class="text-muted text-center fw-normal mt-0">Enter your email and check your
                                            mail</p>
                                    </div>

                                    <div class="mt-4">
                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Email"
                                                    name="email" value="" wire:model.lazy="email" required
                                                    autofocus wire:keydown.enter="sendResetLinkEmail">
                                                @error('email')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mt-4 d-grid">
                                                <a class="btn btn-primary waves-effect waves-light"
                                                    wire:loading.class='disable-button'
                                                    wire:click.prevent='sendResetLinkEmail'>
                                                    <div wire:loading wire:target="sendResetLinkEmail"
                                                        class="spinner-border text-primary spinner-button"
                                                        role="status" aria-hidden="true">
                                                    </div>
                                                    <div wire:loading.remove wire:target="sendResetLinkEmail">Submit
                                                    </div>
                                                </a>
                                            </div>
                                            <a class="btn-link d-block mt-5 p-0 text-center"
                                                href="{{ route('login') }}">
                                                Back to login
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6 col-lg-6 col-xl-8">
                    <div class="d-none d-sm-none d-md-block auth-full-bg h-100vh">
                        <div class="h-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-100 flex-column justify-content-center">
                                <div class="">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-9">
                                            <div class="text-center">
                                                <img class="d-block w-75 m-auto mover" src="./assets/images/forgot.png"
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
            </div>
            <!-- end row -->
        </div>
    </div>
</div>
