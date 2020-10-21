<!DOCTYPE html>
<html lang="en" dir="ltr">


<!-- Mirrored from demo.frontted.com/stackadmin/134/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 05 Oct 2020 15:55:22 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env("APP_NAME") }} - Deploy on push</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <link rel="icon" href="/img/icons/favicon.png">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="/assets/vendor/perfect-scrollbar.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="/assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="/assets/css/app.rtl.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="/assets/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="/assets/css/vendor-material-icons.rtl.css" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="/assets/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="/assets/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">

    <!-- Flatpickr -->
    <link type="text/css" href="/assets/css/vendor-flatpickr.css" rel="stylesheet">
    <link type="text/css" href="/assets/css/vendor-flatpickr.rtl.css" rel="stylesheet">
    <link type="text/css" href="/assets/css/vendor-flatpickr-airbnb.css" rel="stylesheet">
    <link type="text/css" href="/assets/css/vendor-flatpickr-airbnb.rtl.css" rel="stylesheet">

    <!-- Vector Maps -->
    <link type="text/css" href="/assets/vendor/jqvmap/jqvmap.min.css" rel="stylesheet">
    
    <!-- Toastr -->
    <link type="text/css" href="/assets/vendor/toastr.min.css" rel="stylesheet">


    <livewire:styles>

    <script>
        var current_app = null
        var current_hook = null
    </script>

</head>

<body class="layout-default">

    <div class="preloader"></div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">

        <!-- Header -->

        <div id="header" class="mdk-header js-mdk-header m-0" data-fixed>
            <div class="mdk-header__content">

                <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-dark  pr-0" id="navbar" data-primary>
                    <div class="container-fluid p-0">

                        <!-- Navbar toggler -->

                        <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button" data-toggle="sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <!-- Navbar Brand -->
                        <a href="{{ route('dashboard') }}" class="navbar-brand ">
                            <img class="navbar-brand-icon" src="/img/icons/favicon.png" width="22">
                            <span>{{ env("APP_NAME") }}</span>
                        </a>

                        <ul class="nav navbar-nav d-none d-sm-flex border-left navbar-height align-items-center">
                            <li class="nav-item">
                                <a href="#account_menu" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">
                                    <img src="{{ user()->avatar }}" class="rounded-circle" width="32" alt="Frontted">
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
                <div class="mdk-drawer-layout__content page">

                    @yield('content')

                </div>
                <!-- // END drawer-layout__content -->

                <div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
                    <div class="mdk-drawer__content">
                        <div class="sidebar sidebar-light sidebar-left" data-perfect-scrollbar>
                            <div class="sidebar-heading sidebar-m-t">Menu</div>
                            <ul class="sidebar-menu">
                                <li class="sidebar-menu-item {{ current_route() == 'dashboard' ? 'active open' : NULL }}">
                                    <a class="sidebar-menu-button" href="{{ route('dashboard') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left fas fa-th-large"></i>
                                        <span class="sidebar-menu-text">Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="sidebar-heading sidebar-m-t">Contact</div>
                            <ul class="sidebar-menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" target="_blank" href="https://twitter.com/emitng">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left fas fa-award"></i>
                                        <span class="sidebar-menu-text">Sponsor {{ env("APP_NAME") }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" target="_blank" href="https://twitter.com/emitng">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left fas fa-award"></i>
                                        <span class="sidebar-menu-text">Contribute to {{ env("APP_NAME") }}</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="sidebar-heading sidebar-m-t">Extra</div>
                            <ul class="sidebar-menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" onclick="return confirm('are you sure you want to logout ?')" href="{{ route('logout') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">power_settings_new</i>
                                        <span class="sidebar-menu-text">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // END drawer-layout -->

        </div>
        <!-- // END header-layout__content -->

    </div>
    <!-- // END header-layout -->

    <!-- jQuery -->
    <script src="/assets/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="/assets/vendor/popper.min.js"></script>
    <script src="/assets/vendor/bootstrap.min.js"></script>

    <!-- Perfect Scrollbar -->
    <script src="/assets/vendor/perfect-scrollbar.min.js"></script>

    <!-- DOM Factory -->
    <script src="/assets/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="/assets/vendor/material-design-kit.js"></script>

    <!-- App -->
    <script src="/assets/js/toggle-check-all.js"></script>
    <script src="/assets/js/check-selected-row.js"></script>
    <script src="/assets/js/dropdown.js"></script>
    <script src="/assets/js/sidebar-mini.js"></script>
    <script src="/assets/js/app.js"></script>

    <!-- App Settings (safe to remove) -->
    <script src="/assets/js/app-settings.js"></script>



    <!-- Flatpickr -->
    <script src="/assets/vendor/flatpickr/flatpickr.min.js"></script>
    <script src="/assets/js/flatpickr.js"></script>

    <!-- Global Settings -->
    <script src="/assets/js/settings.js"></script>

    <!-- Chart.js -->
    <!-- <script src="/assets/vendor/Chart.min.js"></script> -->

    <!-- App Charts JS -->
    <!-- <script src="/assets/js/charts.js"></script> -->

    <!-- Chart Samples -->
    <!-- <script src="/assets/js/page.dashboard.js"></script> -->

    <!-- Vector Maps -->
    <script src="/assets/vendor/jqvmap/jquery.vmap.min.js"></script>
    <script src="/assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
    <script src="/assets/js/vector-maps.js"></script>

    <!-- Toastr -->
    <script src="/assets/vendor/toastr.min.js"></script>
    <script src="/assets/js/toastr.js"></script>

    <livewire:scripts>
</body>


<!-- Mirrored from demo.frontted.com/stackadmin/134/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 05 Oct 2020 15:56:50 GMT -->
</html>