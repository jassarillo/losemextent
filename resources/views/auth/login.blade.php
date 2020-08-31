<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>SISTEMA BASE</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Sistema de Facturaccion" name="description" />
    <meta content="" name="author" />
    <link rel="icon" type="image/vnd.microsoft.icon" href="{{ asset('assets/media/logos/favicon.ico') }}" sizes="48X16">
    @include('layouts/css/css_header_login')
</head>
<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
            <div
                class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
                <div
                    class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
                    <div class="kt-login__wrapper">
                        <div class="kt-login__container">
                            <div class="kt-login__body">
                                <div class="kt-login__logo">
                                    <a href="#">
                                        <!--<img src="assets/media/company-logos/SAF_logo_header.svg" width="100%">-->
                                    </a>
                                </div>
                                <div class="kt-login__signin">
                                    <div class="kt-login__head">
                                        <h3 class="kt-login__title">Ingresar</h3>
                                    </div>
                                    <div class="kt-login__form">
                                        <form method="POST" class="kt-form">
                                            @csrf
                                            <div class="form-group">
                                                <!--  ***** -->
                                                <!-- se puede validar por usuario o por correo dependiendo de lo requerido-->
                                                <!--  <input class="form-control" type="email" placeholder="Email" id="email" name="email" autocomplete="off">-->
                                                <!--  ***** -->
                                                <input class="form-control placeholder-no-fix" type="text"
                                                    autocomplete="off" placeholder="Usuario" name="username" required />
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control form-control-last" type="password"
                                                    placeholder="Contraseña" name="password" required>
                                            </div>
                                            <div class="kt-login__extra">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="remember"> Recordarme
                                                    <span></span>
                                                </label>
                                                <a href="javascript:;" id="kt_login_forgot"> ¿Olvidaste tu Contraseña
                                                    ?</a>
                                            </div>
                                            <div class="kt-login__actions">
                                                <button id="kt_login_signin_submit"
                                                    class="btn btn-brand btn-pill btn-elevate">Entrar</button>
                                                   <!-- <button id="kt_login_correo"  class="btn btn-brand btn-pill btn-elevate">correo</button>-->
                                                <!--<button  class="btn btn-brand btn-pill btn-elevate"xtype="submit" class="btn green pull-right"> Entrar </button>-->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="kt-login__signup">
                                    <div class="kt-login__head">
                                        <h3 class="kt-login__title">Registar</h3>
                                        <div class="kt-login__desc">Ingrese sus datos para crear su cuenta:</div>
                                    </div>
                                    <div class="kt-login__form">
                                        <!--<form class="kt-form" action="#">-->
                                        <form method="POST" class="kt-form" action="{{ route('login') }}">

                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Nombre Completo"
                                                    name="nombre">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Apellido Paterno"
                                                    name="apaterno">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Apellido Materno"
                                                    name="amaterno">
                                            </div>
                                            <div class="form-group">
                                                 <input class="form-control" type="text" placeholder="Correo electrónico" id="remail"name="remail" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Usuario" id="user"
                                                    name="user" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" placeholder="Contraseña"
                                                    id='password' name="password">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control form-control-last" type="password"
                                                    placeholder="Confirmar Contraseña" id='password_confirmation'
                                                    name="password_confirmation">
                                            </div>
                                            <div class="kt-login__extra">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="agree"> Acepto los <a href="javascript:void(0)" id="termCond">términos
                                                        y condiciones</a>.
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="kt-login__actions">
                                                <button id="kt_login_signup_submit"
                                                    class="btn btn-brand btn-pill btn-elevate">Registrar</button>
                                                <button id="kt_login_signup_cancel"
                                                    class="btn btn-outline-brand btn-pill">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="kt-login__forgot">
                                    <div class="kt-login__head">
                                        <h3 class="kt-login__title">¿ Contraseña Olvidada ?</h3>
                                        <div class="kt-login__desc">Ingrese su correo electrónico para restablecer su
                                            contraseña:</div>
                                    </div>
                                    <div class="kt-login__form">
                                        <form class="kt-form" action="#">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Correo" name="email"
                                                    id="kt_email" autocomplete="off">
                                            </div>
                                            <div class="kt-login__actions">
                                                <button id="kt_login_forgot_submit"
                                                    class="btn btn-brand btn-pill btn-elevate">Enviar</button>
                                                <button id="kt_login_forgot_cancel"
                                                    class="btn btn-outline-brand btn-pill">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-login__account">
                            <span class="kt-login__account-msg">
                                ¿Aún no tienes una cuenta?
                            </span>&nbsp;&nbsp;
                            <a href="javascript:;" id="kt_login_signup" class="kt-login__account-link">Regístrate!</a>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token">
                        </div>
                    </div>
                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content"
                    style="background-image: url(assets/media/bg/bg-5.jpg);  background-repeat: no-repeat; background-position: center; ">
                    <div class="kt-login__section">
                        <div class="kt-login__block">
                            <h3 class="kt-login__title">fzs</h3>
                            <div class="kt-login__desc">
                                By Capa75
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Page -->

    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
        // var global URL
    var url = '{!! URL::asset('') !!}';

    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
    </script>
    <!-- end::Global Config -->
    <!--begin::Global Theme Bundle(used by all pages) -->
    @include('layouts/scripts/js_header_login')

    <!--end::Global Theme Bundle -->
</body>

</html>
