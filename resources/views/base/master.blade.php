<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>{{ config('company.company') ?? 'ERAV' }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('media/logos/logo.png') }}" />
    <meta name="base-url" content="{{ url('/') }}">

    <!--begin::Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--end::Fonts-->

    <!--begin::Vendor Stylesheets-->
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/dataTables.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!--end::Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom-layout.css') }}" rel="stylesheet" type="text/css" />

    <style>
        body { font-family: 'Inter', sans-serif; }
        [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length select {
            background-color: #23272b !important;
            color: #fff !important;
        }
        .dataTables_length {
            padding-top: 10px !important;
            padding-bottom: 4vh !important;
        }
        .dataTables_filter {
            display: none !important;
        }
    </style>
    <!--end::Global Stylesheets Bundle-->
    <script>if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_app_body" class="app-default app-designer-layout">

    <!-- MOBILE TOP BAR (visible on small screens only) -->
    <div class="designer-mobile-topbar">
        <button id="mobileMenuBtn" class="designer-mobile-btn" type="button">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        <div class="logo-brand-text">
            <span class="text-blue">Erav</span> ERAV
        </div>
    </div>

    <!-- MOBILE OVERLAY -->
    <div id="mobileOverlay" class="designer-mobile-overlay"></div>

    <!-- SIDEBAR -->
    @include('base.navbar')

    <!-- MAIN CONTENT CONTAINER -->
    <div class="designer-main-container">
        <!-- DESKTOP TOP BAR -->
        @include('base.header')

        <!-- PAGE CONTENT CONTAINER -->
        <main class="designer-main-content">
            @yield('content')
        </main>
    </div>

    <!--begin::Javascript-->
    <!-- jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Metronic / Bootstrap bundle -->
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom Layout JS -->
    <script src="{{ asset('js/custom-layout.js') }}"></script>

    <!-- Select2 (AFTER jQuery & Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Vendors -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Page-specific JS -->
    <script src="{{ asset('js/custom/apps/ecommerce/customers/listing/listing.js') }}"></script>
    <script src="{{ asset('js/custom/apps/ecommerce/customers/listing/add.js') }}"></script>
    <script src="{{ asset('js/custom/apps/ecommerce/customers/listing/export.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Flash Message & AJAX Error Handler -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    });

    $(document).ready(function() {
        if ($('#cusVisitDays').length) {
            $('#cusVisitDays').select2({
                width: '100%',
                placeholder: 'Select days...'
            });
        }
    });

    // Base URL setup for AJAX
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
        if (options.url.startsWith('/')) {
            options.url = baseUrl + '/' + options.url.substring(1);
        }
    });
    </script>

    @yield('scripts')
</body>
<!--end::Body-->
</html>