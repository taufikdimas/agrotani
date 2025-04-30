<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('sneat/assets') }}/" data-template="vertical-menu-template-free">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard') | Agrotani</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Iconify / Boxicons / Icon CSS -->
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/iconify-icons.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}"> --}}

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/apex-charts/apex-charts.css') }}">

  <!-- Helpers -->
  <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
  <!-- jQuery HARUS duluan -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap & DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


  @stack('styles')
</head>
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      {{-- Sidebar --}}
      @include('layouts.sidebar')

      <!-- Layout container -->
      <div class="layout-page">

        {{-- Header --}}
        @include('layouts.header')

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Main content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
          </div>

          {{-- Footer --}}
          @include('layouts.footer')
        </div>

      </div>
    </div>
  </div>


<!-- jQuery HARUS duluan -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap & DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Load Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Core JS -->
<script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>

<!-- Vendors JS -->
<script src="{{ asset('sneat/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('sneat/assets/js/main.js') }}"></script>

<!-- Page JS (optional) -->
<script src="{{ asset('sneat/assets/js/dashboards-analytics.js') }}"></script>

<!-- Github Widget (optional) -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Optional: Your custom page-specific scripts -->
@stack('scripts')

</body>
</html>
