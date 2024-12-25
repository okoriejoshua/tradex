<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'tradex') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/ui/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/ui/css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css')}}">
    <livewire:styles />
</head>

<body class="hold-transition gold-theme sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div id="pre-loader" style="display:flex; justify-content: center; align-items:center; background-color:black; width:100%; height:100%; position:fixed; top:0px;left:0px;z-index:9999; opacity:.75">
            <div class="lds-roller">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        @include('layouts.partials.admins.navbar')
        @include('layouts.partials.admins.sidebar')
        <div class="content-wrapper">
            {{$slot}}
        </div>
        @include('layouts.partials.admins.footer')
    </div>
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{ asset('backend/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('backend/ui/js/adminlte.js')}}"></script>
    <script src="{{ asset('backend/ui/js/events.function.js')}}"></script>
    <livewire:scripts />
    <script src="{{ asset('backend/ui/js/alpinejs.v2.js')}}"></script>
</body>

</html>