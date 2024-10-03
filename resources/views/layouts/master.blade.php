<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Icons Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/lr-favicon.png') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">

    @vite('resources/scss/main.scss')
    @livewireStyles
    @stack('styles')
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== Header Start ========== -->
        @include('layouts.header')
        <!-- ========== Header Ebd ========== -->


        <!-- ========== Left Sidebar Start ========== -->
        @include('layouts.sidebar')
        <!-- ========== Left Sidebar End ========== -->



        <!-- ============Start main Content here=================== -->
        <div class="main-content">
            @yield('main-content')
        </div>
        <!-- ============End main Content here=================== -->

        <!-- ========== Footer Start ========== -->
        @include('layouts.footer')
        <!-- ========== Footer Ebd ========== -->

    </div>
    <!-- END layout-wrapper -->
    <!-- BEGIN: JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.repeater.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    @livewireScripts
    <!-- Focus plugin -->
    <script defer src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine v3 -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        $(".select2").select2({
            minimumResultsForSearch: Infinity
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        window.addEventListener('alert', ({
            detail: {
                type,
                message
            }
        }) => {
            Toast.fire({
                icon: type,
                title: message
            });
        })

        $(document).ready(function() {
            @if (Session::has('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ Session('error') }}"
                });
            @elseif (Session::has('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ Session('success') }}"
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>

</html>
