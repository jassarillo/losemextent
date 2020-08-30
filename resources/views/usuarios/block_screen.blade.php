<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>
    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="../">
    <!--end::Base Path -->
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema | General</title>

    <link rel="icon" type="image/vnd.microsoft.icon" href="{{ asset('assets/media/logos/favicon.ico') }}" sizes="48X16">
    <!--begin::Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    <!--end::Fonts -->
    <link href="{{ asset('assets/css/login-3.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/vendors.bundle.css') }}" rel="stylesheet">


    <link href="{{ asset('assets/css/demo1/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->

    <link href="{{ asset('assets/css/demo1/skins/header/base/light.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/demo1/skins/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('assets/css/demo1/skins/brand/dark.css')}}" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="{{ asset('assets/css/demo1/skins/aside/dark.css')}}" rel="stylesheet" type="text/css" />   -->
    <link href="{{ asset('assets/css/demo1/skins/brand/light.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/demo1/skins/aside/light.css')}}" rel="stylesheet" type="text/css" />

</head>


<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">


    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor"
                style="background-image: url( {{ asset('assets/media/bg/bg-3.jpg')}});">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__logo">
                            <a href="#">
                                <img src="{{env('APP_URL').'storage/app/'.Auth::user()->avatar}}">
                            </a>
                        </div>
                        <div class="kt-login__signin">
                            <div class="kt-login__head">
                                <h3 class="kt-login__title"></i>{{Auth::user()->usuario}}</h3>
                            </div>
                            <form class="kt-form" action="">
                                <div class="input-group">
                                    <input class="form-control" type="password" placeholder="Password" name="password">
                                </div>
                                <div class="kt-login__actions">
                                    <button id="kt_login_signin_submit" type="button"
                                        class="btn btn-brand btn-elevate kt-login__btn-primary">Desbloquear</button>
                                </div>
                            </form>
                        </div>
                        <div class="kt-login__account">
                            <a href="{{ route('logout') }}" id="kt_login_signup" class="kt-login__account-link">¿No eres {{Auth::user()->name}}?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Page -->


</body>


</html>