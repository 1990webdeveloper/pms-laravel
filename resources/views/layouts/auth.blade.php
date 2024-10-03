<!DOCTYPE html>
<html lang="en">

<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Logicrays</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/lr-favicon.png') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">

    @vite('resources/scss/main.scss')
    @livewireStyles
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body>

    {{ $slot }}
    <!-- BEGIN: JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" crossorigin="anonymous"></script>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Focus plugin -->
    <script defer src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine v3 -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
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
            setTimeout(function() {
                Toast.fire({
                    icon: type,
                    title: message
                });
            }, 1000);
        })

        $(document).ready(function() {
            @if (Session::has('error'))
                setTimeout(function() {
                    Toast.fire({
                        icon: 'error',
                        title: "{{ Session('error') }}"
                    });
                }, 1000);
            @elseif (Session::has('success'))
                setTimeout(function() {
                    Toast.fire({
                        icon: 'success',
                        title: "{{ Session('success') }}"
                    });
                }, 1000);
            @endif
        });
    </script>
    <script>
        $(function() {
            $('.eye-icon').click(function() {
                if ($(this).hasClass('bi-eye-slash')) {
                    $(this).removeClass('bi-eye-slash');
                    $(this).addClass('bi-eye');
                    $(this).parent().children('input').attr('type', 'text');
                } else {
                    $(this).removeClass('bi-eye');
                    $(this).addClass('bi-eye-slash');
                    $(this).parent().children('input').attr('type', 'password');
                }
            });
        });
    </script>

    @stack('script')
</body>
<!-- END: Body-->

</html>
