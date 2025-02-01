<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MBKM UNIKOM</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="/js/plugins/sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" href="/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
        <link rel="stylesheet" href="/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
        <link rel="stylesheet" href="/js/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/js/plugins/flatpickr/flatpickr.min.css">
    

        @stack('styles')
        <!-- Scripts -->
        @vite(['resources/sass/main.scss', 'resources/js/codebase/app.js', 'resources/js/app.js'])
        <style>
            .content-header{
                height: 5.25rem !important;
            }
        </style>
    </head>
    <body>
        <div id="page-container" class="main-content-boxed side-scroll">

            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="space-x-1">
                        <!-- Logo -->
                        <a class="fw-bold" href="{{ route('home') }}">
                            <img src="/images/logo.png" style="width: 250px;"/>
                        </a>
                        <!-- END Logo -->
                    </div>
                    <!-- END Left Section -->

                    <div class="d-flex">
                        <ul class="nav-main nav-main-horizontal nav-main-hover me-2">
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="{{ route('program.index') }}">
                                    <span class="nav-main-link-name">Program</span>
                                </a>
                            </li>
                        </ul>

                        @if (Auth::guard('web')->check())
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-alt-secondary rounded-pill" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user"></i>
                                <span class="d-none d-sm-inline-block fw-semibold">{{ Auth::guard('web')->user()->nama }}</span>
                                <i class="fa fa-angle-down opacity-50 ms-1"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-md border dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
                                <div class="pt-2 px-2">
                                    <div class="bg-body-light p-2 rounded">
                                        <h5 class="fs-6 fw-medium mb-0">
                                            {{ Auth::guard('web')->user()->nama }}
                                        </h5>
                                        <div class="fs-sm">{{ Auth::guard('web')->user()->nim }}</div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                                        href="{{ route('profil.edit') }}">
                                        <span>Profil</span>
                                        <i class="fa fa-fw fa-user opacity-25"></i>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                                        href="{{ route('user.program') }}">
                                        <span>Program Saya</span>
                                        <i class="fa fa-fw fa-user opacity-25"></i>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="{{ route('profil.password') }}">
                                        <span>Ubah Password</span>
                                        <i class="fa fa-fw fa-envelope-open opacity-25"></i>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                            <span>Keluar</span>
                                            <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="space-x1">
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                            </div>
                        @endif
                    </div>
                    <!-- END Middle Section -->
                </div>
                <!-- END Header Content -->
            </header>

            <!-- Page Content -->
            <main id="main-container">
                {{ $slot }}
            </main>
        </div>
        
        <script src="/js/jquery.min.js"></script>
        <script src="/js/plugins/sweetalert2/sweetalert2.min.js"></script>
        <script src="/js/plugins/flatpickr/flatpickr.min.js"></script>
        <script src="/js/plugins/flatpickr/l10n/id.js"></script>
        <script src="/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
        <script src="/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
        <script src="/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
        <script src="/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
        <script src="/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
        <script src="/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
        <script src="/js/plugins/datatables-buttons/buttons.print.min.js"></script>
        <script src="/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
