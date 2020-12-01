@extends('home')
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <!--<div class="col-xl-8 order-lg-4 order-xl-1">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div
                    class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Licitaciones dentro de la Unidad Administrativa
                        </h3>
                    </div>
                    <div class="kt-widget19__stats">
                                <br><span class="kt-widget19__number kt-font-cdmx ">
                                </span>
                                <a href="#" class="kt-widget19__comment kt-font-cdmx">
                                   Licitaciones Registrada<br>

                                </a>
                                <br>
                            </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="dropdown dropdown-inline">
                            <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="flaticon-more-1"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-md dropdown-menu-fit">
                                <ul class="kt-nav">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    
                    <table class="table table-striped- table-bordered table-hover table-checkable"
                        id="resumen_licitaciones-table">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Nombre de la Licitacion </th>
                                <th> Numero </th>

                                <th> Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_latest_orders"></div>
                </div>
            </div>

        </div>-->
        <!--<div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">
            <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                <div class="kt-portlet__body kt-portlet__body--fit kt-portlet__body--unfill">
                    <div class="kt-widget19__pic kt-portlet-fit--top kt-portlet-fit--sides"
                        style="min-height: 300px; background-image: url(./public/assets/media/logos/proveedores.png)">
                        <h3 class="kt-widget19__title kt-font-light">
                            Catalogo de Proveedores
                        </h3>
                        <div class="kt-widget19__shadow"></div>

                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-widget19__wrapper">
                        <div class="kt-widget19__content">
                            <div class="kt-widget19__userpic">
                                <img src="./assets/media//users/user1.jpg" alt="">
                            </div>
                            <div class="kt-widget19__info">
                                <a href="#" class="kt-widget19__username">
                                    Buscador de proveedores
                                </a>

                            </div>
                            <div class="kt-widget19__stats">
                                <span class="kt-widget19__number kt-font-cdmx ">
                                </span>
                                <a href="#" class="kt-widget19__comment kt-font-cdmx">
                                    Proveedores Registrados<br>
                                    en Subastas
                                </a>
                            </div>
                        </div>
                        <div class="kt-widget19__text">
                            En esta liga se podra buscar si el proveedor esta registrado en el Tianguis Digital el cual
                            sera busacando por su rfc.
                            <br><a href=https://www.tianguisdigital.cdmx.gob.mx/proveedores/ target="_blank"
                                class="kt-font-cdmx">IR al Tianguis Digital</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    <div class="row">
        <!--<div class="col-xl-6">
          
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Subastas Generadas <small>Baja de precio</small>
                        </h3>
                    </div>
                    <div class="kt-widget19__stats">
                                <br><span class="kt-widget19__number kt-font-cdmx ">
                                </span>
                                <a href="#" class="kt-widget19__comment kt-font-cdmx">
                                   Subastas Registradas<br>

                                </a>
                                <br>
                            </div>
                    <div class="kt-portlet__head-toolbar">
                    <a href="#" class="btn btn-label-success btn-bold btn-sm dropdown-toggle"
                            data-toggle="dropdown">
                            Herramientas
                        </a>
                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
                           
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-widget16">
                        <div class="kt-widget16__items">
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__sceduled">
                                    Licitacion Por Partida
                                </span>
                                <span class="kt-widget16__amount">
                                    Rondas
                                </span>
                            </div>
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__date">
                                    2141 - Toner
                                </span>
                                <span class="kt-widget16__price  kt-font-brand">
                                    27
                                </span>
                            </div>
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__date">
                                    5151 - Computo
                                </span>
                                <span class="kt-widget16__price  kt-font-success">
                                    14
                                </span>
                            </div>
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__date">
                                    5911 - Software
                                </span>
                                <span class="kt-widget16__price  kt-font-danger">
                                    20
                                </span>
                            </div>

                        </div>
                        <div class="kt-widget16__stats">
                            <div class="kt-widget16__visual">
                                <div id="kt_chart_support_tickets" style="height: 160px; width: 160px;"><svg
                                        height="160" version="1.1" width="160" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        style="overflow: hidden; position: relative; top: -0.234375px;">
                                        <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with
                                            Raphaël 2.3.0</desc>
                                        <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                        <path fill="none" stroke="#34bfa3"
                                            d="M80,126.66666666666666A46.666666666666664,46.666666666666664,0,0,0,124.95894304729406,92.50884558414354"
                                            stroke-width="2" opacity="0"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path>
                                        <path fill="#34bfa3" stroke="#ffffff"
                                            d="M80,129.66666666666666A49.666666666666664,49.666666666666664,0,0,0,127.84916081462009,93.31298565740991L142.621384958731,97.42303492077136A65,65,0,0,1,80,145Z"
                                            stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path>
                                        <path fill="none" stroke="#5d78ff"
                                            d="M124.95894304729406,92.50884558414354A46.666666666666664,46.666666666666664,0,1,0,49.80816419397199,115.5841373148152"
                                            stroke-width="2" opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path>
                                        <path fill="#5d78ff" stroke="#ffffff"
                                            d="M127.84916081462009,93.31298565740991A49.666666666666664,49.666666666666664,0,1,0,47.86726046358448,117.87168899933903L34.712246290957985,133.37620597222278A70,70,0,1,1,147.4384145709411,98.76326837621531Z"
                                            stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path>
                                        <path fill="none" stroke="#fd3995"
                                            d="M49.80816419397199,115.5841373148152A46.666666666666664,46.666666666666664,0,0,0,79.98533923452442,126.666664363759"
                                            stroke-width="2" opacity="0"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path>
                                        <path fill="#fd3995" stroke="#ffffff"
                                            d="M47.86726046358448,117.87168899933903A49.666666666666664,49.666666666666664,0,0,0,79.98439675674383,129.66666421571492L79.97957964808758,144.9999967923786A65,65,0,0,1,37.947085841603844,129.56361983134974Z"
                                            stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path><text x="80" y="70" text-anchor="middle" font-family="&quot;Arial&quot;"
                                            font-size="15px" stroke="none" fill="#a7a7c2"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;"
                                            font-weight="800" transform="matrix(1.0606,0,0,1.0606,-4.8589,-4.9091)"
                                            stroke-width="0.942857142857143">
                                            <tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Toner
                                            </tspan>
                                        </text><text x="80" y="90" text-anchor="middle" font-family="&quot;Arial&quot;"
                                            font-size="14px" stroke="none" fill="#a7a7c2"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;"
                                            transform="matrix(0.9722,0,0,0.9722,2.225,2.2778)"
                                            stroke-width="1.0285714285714287">
                                            <tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">56
                                            </tspan>
                                        </text>
                                    </svg>
                                </div>
                            </div>
                            <div class="kt-widget16__legends">
                                <div class="kt-widget16__legend">
                                    <span class="kt-widget16__bullet kt-bg-info"></span>
                                    <span class="kt-widget16__stat">20% Margins</span>
                                </div>
                                <div class="kt-widget16__legend">
                                    <span class="kt-widget16__bullet kt-bg-success"></span>
                                    <span class="kt-widget16__stat">80% Profit</span>
                                </div>
                                <div class="kt-widget16__legend">
                                    <span class="kt-widget16__bullet kt-bg-danger"></span>
                                    <span class="kt-widget16__stat">10% Lost</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>-->
        <!--<div class="col-xl-6">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Proveedores Registrados <small>en el sistema de Subasta</small>
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <a href="#" class="btn btn-label-success btn-bold btn-sm dropdown-toggle"
                            data-toggle="dropdown">
                            Herramientas
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md">
                            
                            <ul class="kt-nav">
                                <li class="kt-nav__head">
                                    Export Options
                                    <span data-toggle="kt-tooltip" data-placement="right" title=""
                                        data-original-title="Click to learn more...">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1"
                                            class="kt-svg-icon kt-svg-icon--brand kt-svg-icon--md1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                                                <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"></rect>
                                                <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"></rect>
                                            </g>
                                        </svg> </span>
                                </li>
                                <li class="kt-nav__separator"></li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-drop"></i>
                                        <span class="kt-nav__link-text">Activity</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-calendar-8"></i>
                                        <span class="kt-nav__link-text">FAQ</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-telegram-logo"></i>
                                        <span class="kt-nav__link-text">Settings</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-new-email"></i>
                                        <span class="kt-nav__link-text">Support</span>
                                        <span class="kt-nav__link-badge">
                                            <span class="kt-badge kt-badge--success kt-badge--rounded">5</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="kt-nav__separator"></li>
                                <li class="kt-nav__foot">
                                    <a class="btn btn-label-danger btn-bold btn-sm" href="#">Upgrade plan</a>
                                    <a class="btn btn-clean btn-bold btn-sm" href="#" data-toggle="kt-tooltip"
                                        data-placement="right" title=""
                                        data-original-title="Click to learn more...">Learn more</a>
                                </li>
                            </ul>
                          
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-widget16">
                    <table class="table table-striped- table-bordered table-hover table-checkable"
                        id="resumen_proveedor-table">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Proveedor</th>
                                <th> Licitacion Participante </th>
                                <th> Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</div>
@endsection
