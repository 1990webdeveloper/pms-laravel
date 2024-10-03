<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <div class="logo">
                    <a href="{{ route('user.dashboard') }}">
                        <span class="logo-sm">
                            <img src="{{ asset('/assets/images/lr.svg') }}" alt="logo">
                        </span>
                        <div class="logo-lg">
                            <img src="{{ asset('/assets/images/logo.svg') }}" alt="logo">
                        </div>
                    </a>
                </div>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item " id="vertical-menu-btn">
                <i class="bi bi-list"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="bi bi-search"></span>
                </div>
            </form>


        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon " data-bs-toggle="fullscreen">
                    <i class="bi bi-fullscreen"></i>
                </button>
            </div>

            <div class="toggle-container">
                <button class="btn theme-btn light header-item" onclick="setTheme('light')" title="Light mode">
                    <i class="bi bi-brightness-high fs-5"></i>
                </button>
                <button class="btn theme-btn dark header-item" onclick="setTheme('dark')" title="Dark mode">
                    <i class="bi bi-moon fs-5"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon " id="page-header-notifications-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-danger rounded-pill">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 notification-list"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0" key="t-notifications"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small"> View All</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">

                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="{{ asset('assets/images/avatar.png') }}" class="me-3 rounded-circle avatar-xs"
                                    alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-12 ">
                                        <p class="mb-1 text-muted">It will seem like simplified
                                            English.</p>
                                        <p class="mb-0 n-time"><i class="bi bi-clock"></i>
                                            <span>1 hours ago</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="{{ asset('assets/images/avatar.png') }}" class="me-3 rounded-circle avatar-xs"
                                    alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-12 ">
                                        <p class="mb-1 text-muted">It will seem like simplified
                                            English.</p>
                                        <p class="mb-0 n-time"><i class="bi bi-clock"></i>
                                            <span>1 hours ago</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="{{ asset('assets/images/avatar.png') }}" class="me-3 rounded-circle avatar-xs"
                                    alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-12 ">
                                        <p class="mb-1 text-muted">It will seem like simplified
                                            English.</p>
                                        <p class="mb-0 n-time"><i class="bi bi-clock"></i>
                                            <span>1 hours ago</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="{{ asset('assets/images/avatar.png') }}" class="me-3 rounded-circle avatar-xs"
                                    alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-12 ">
                                        <p class="mb-1 text-muted">It will seem like simplified
                                            English.</p>
                                        <p class="mb-0 n-time"><i class="bi bi-clock"></i>
                                            <span>1 hours ago</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                More..</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item " id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('/assets/images/avatar.png') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ AppHelper::getLoginUser()->name }}</span>
                    <i class="bi bi-chevron-down d-none d-xl-inline-block fs-6 ms-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                        <i class="bi bi-person fs-5 align-middle me-1"></i> <span>Profile</span></a>
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="bi bi-box-arrow-right fs-5 align-middle me-1"></i> <span>Logout</span></a>
                    </a>

                </div>
            </div>

        </div>
    </div>
</header>
