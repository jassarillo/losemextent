<!DOCTYPE html>
<html lang="en">
<head>
    <base href="../">
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema | General</title>
    <link rel="icon" type="image/vnd.microsoft.icon" href="{{ asset('assets/media/logos/favicon.ico') }}" sizes="48X16">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    @include('layouts/css/css')
    @yield('styles')  
</head>
@guest
<body 
    <?php ?> 
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-page--loading"  >
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="demo1/index.html">
                <img alt="Logo" src="{{ URL::asset('assets/media/logos/logo-light.png')}}" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left"
                id="kt_aside_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
        </div>
    </div>
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                        @yield('content')                       
                    </div>
                </div>
                @include('layouts/footer/footer')
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="kt-scrolltop">
		<i class="fa fa-arrow-up"></i>
    </div>
    @include('layouts/scripts/scriptsGuest')
    <script src="{{ URL::asset('js/layout.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var url = '{!! URL::asset('') !!}';        
        </script>
    @yield('scripts')
</body>
    @else>
@endguest

</html>