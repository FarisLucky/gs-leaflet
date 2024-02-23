<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') || E-LEAFLET</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/leaflet.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;900&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('/dist/fonts/tabler-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/dist/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dist/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dist/css/rtl/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/dist/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('/dist/css/custom.css') }}" />

    <!-- LOADING BAR -->
    <link rel="stylesheet" href="{{ asset('/dist/libs/ldbar/loading-bar.css') }}">
    @stack('css')
    <!-- Helpers -->
    <script src="{{ asset('/dist/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{-- <script src="{{ asset('/dist/js/template-customizer.js') }}"></script> --}}
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <style>
        .loader {
            position: fixed;
            top: 50%;
            right: 50%;
            z-index: 9999;
        }

        .loader.hide {
            display: none;
        }

        .loader.show {
            display: inline-block;
        }

        .loader-wrapper {
            padding: .2rem;
            background: white;
            border-radius: 5px;
            border: 1px solid #bcbcbc6b
        }

        .loader-wrapper::after {
            content: 'loading';
            margin-left: .3rem;
            font-size: 12px;
        }
    </style>
</head>

<body>
    {{-- <div class="ldBar" style="height: 10px; width: 100%" data-preset="line" data-value="50" data-fill-dir="ltr"></div> --}}
    <!-- Layout wrapper -->
    <div class="loader">
        <div class="loader-wrapper">
            <img src="{{ asset('loader2.gif') }}" style="width: 40px">
        </div>
    </div>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('layouts.navbar')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('/dist/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/dist/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('/dist/libs/i18n/i18n.js') }}"></script>

    <script src="{{ asset('/dist/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- LOADING BAR JS -->
    <script src="{{ asset('/dist/libs/ldbar/loading-bar.js') }}"></script>
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var API_TOKEN = $('meta[name="api-token"]').attr('content');
        var loader = document.querySelector('.loader')

        function hideLoader() {
            loader.classList.remove('show')
            loader.classList.add('hide')
        }

        function showLoader() {
            loader.classList.remove('hide')
            loader.classList.add('show')
        }
    </script>
    @stack('javascript')
</body>

</html>
