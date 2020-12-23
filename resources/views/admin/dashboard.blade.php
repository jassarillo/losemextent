@extends('home')
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
            <!--begin:: Portlet-->
<div class="kt-portlet ">
    <div class="kt-portlet__body">
        <div class="kt-widget kt-widget--user-profile-3">
           
            <div class="kt-widget__bottom">

                <div class="kt-widget__item">
                    <a href="{{ url('admin/alta_bienes') }}">
                    <div class="kt-widget__icon">
                        <i class="flaticon-interface-3"></i>
                    </div>
                    </a>
                        <div class="kt-widget__details">
                            <span class="kt-widget__title">Secciones</span>
                            <span class="kt-widget__value" id="idSecciones"></span>
                        </div>
                    
                </div>
                </a>

                <div class="kt-widget__item">
                    <a href="{{ url('admin/alta_bienes') }}">
                    <div class="kt-widget__icon">
                        <i class="flaticon-list"></i>
                    </div>
                    </a>
                    <div class="kt-widget__details">
                        <span class="kt-widget__title">Bienes</span>
                        <span class="kt-widget__value" id="idBienes"></span>
                    </div>
                </div>

                <div class="kt-widget__item">
                    <a href="{{ url('admin/list_inventario') }}">
                    <div class="kt-widget__icon">
                        <i class="flaticon-list-2"></i>
                    </div>
                    </a>
                    <div class="kt-widget__details">
                        <span class="kt-widget__title">Inventario</span>
                        <span class="kt-widget__value" id="idInventario"></span>
                    </div>
                </div>

                <div class="kt-widget__item">
                    <a href="{{ url('admin/list_eventos') }}">
                    <div class="kt-widget__icon">
                        <i class="flaticon-calendar-3"></i>
                    </div>
                    </a>
                    <div class="kt-widget__details">
                        <span class="kt-widget__title">Eventos</span>
                        <span class="kt-widget__value" id="idEventos"></span>
                    </div>
                </div>

                <div class="kt-widget__item">
                    <div class="kt-widget__icon">
                        <i class="flaticon-users"></i>
                    </div>
                    <div class="kt-widget__details">
                        <span class="kt-widget__title">Empleados</span>
                        <span class="kt-widget__value" id="idEmpleados"></span>
                    </div>
                </div>

                <div class="kt-widget__item">
                    <!--<div class="kt-widget__icon">
                        <i class="flaticon-network"></i>
                    </div>
                    <div class="kt-widget__details">
                        <div class="kt-section__content kt-section__content--solid">
                            <div class="kt-media-group">
                                <a href="#" class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                    <img src="./assets/media/users/100_7.jpg" alt="image">
                                </a>
                                <a href="#" class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                    <img src="./assets/media/users/100_3.jpg" alt="image">
                                </a>
                                <a href="#" class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                    <img src="./assets/media/users/100_2.jpg" alt="image">
                                </a>
                                <a href="#" class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Luke Walls">
                                    <img src="./assets/media/users/100_13.jpg" alt="image">
                                </a>
                                <a href="#" class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                    <img src="./assets/media/users/100_4.jpg" alt="image">
                                </a>
                                <a href="#" class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                    <span>+3</span>
                                </a>
                            </div>         
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--end:: Portlet-->

        <!--Begin::Section-->
<div class="row">
    <div class="col-xl-6">
        <!--begin:: Portlet-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <!--begin::Widget -->
                <div class="kt-widget kt-widget--project-1">
                    <div class="kt-widget__head">
                        <div class="kt-widget__label">
                            <div class="kt-widget__media">
                                <span class="kt-media kt-media--lg kt-media--circle"> 
                                    <img src="{{ URL::asset('assets/media/logos/header-nav.png') }}">  
                                </span>
                            </div>
                            <div class="kt-widget__info kt-margin-t-5">
                                <a href="#" class="kt-widget__title">
                                    Elementos Disponibles                                                 
                                </a>
                                <span class="kt-widget__desc">
                                    Inventario en almacén  
                                </span>
                            </div>
                        </div>
                       
                    </div>

                    <div class="kt-widget__body">
                        <div class="kt-widget__stats">
                            <div class="kt-portlet__body">
                                <!-- Otro form -->
                                    <table class="table table-striped- table-bordered table-hover table-checkable"
                                        id="disponibles" name="disponibles">
                                        <thead>
                                            <tr>
                                                <th> Nro.</th>
                                                <th> Sección</th>
                                                <th> Cantidad</th>
                                            </tr>
                                        </thead>
                                    </table>
                                <!-- Otro form -->
                            </div>
                        </div>

                       

                      
                    </div>

                    <div class="kt-widget__footer">
                        <!--<div class="kt-widget__wrapper">
                            <div class="kt-widget__section">
                                <div class="kt-widget__blog">
                                    <i class="flaticon2-list-1"></i>
                                    <a href="#" class="kt-widget__value kt-font-brand">72 Tasks</a>
                                </div>

                                <div class="kt-widget__blog">
                                    <i class="flaticon2-talk"></i>
                                    <a href="#" class="kt-widget__value kt-font-brand">648 Comments</a>
                                </div>
                            </div>

                            <div class="kt-widget__section">
                                <button type="button" class="btn btn-brand btn-sm btn-upper btn-bold">details</button>                                 
                            </div>
                        </div>-->
                    </div>
                </div>
                <!--end::Widget -->
            </div>
        </div>
        <!--end:: Portlet-->
    </div>
    <div class="col-xl-6">
        <!--begin:: Portlet-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <!--begin::Widget -->
                <div class="kt-widget kt-widget--project-1">
                    <div class="kt-widget__head">
                        <div class="kt-widget__label">
                            <div class="kt-widget__media">
                                <span class="kt-media kt-media--lg kt-media--circle kt-hidden-"> 
                                    <img src="{{ URL::asset('assets/media/logos/header-nav.png') }}">  
                                </span>
                                <span class="kt-media kt-media--lg kt-media--circle kt-hidden"> 
                                    <img src="./assets/media/users/100_11.jpg" alt="image">  
                                </span>                             
                            </div>
                            <div class="kt-widget__info kt-margin-t-5">
                                <a href="#" class="kt-widget__title">
                                    Elementos En Uso                                                 
                                </a>
                                <span class="kt-widget__desc">
                                    Bienes destinados a eventos o salida por petición personal
                                </span>
                            </div>
                        </div>    
                        
                    </div>
                   
                    <div class="kt-widget__body">
                        <div class="kt-portlet__body">
                                <!-- Otro form -->
                                    <table class="table table-striped- table-bordered table-hover table-checkable"
                                        id="enUso-table" name="enUso-table">
                                        <thead>
                                            <tr>
                                                <th> Nro.</th>
                                                <th> Sección</th>
                                               
                                                <th> Cantidad</th>
                                            </tr>
                                        </thead>
                                    </table>
                                <!-- Otro form -->
                            </div>
                    </div>

                    <div class="kt-widget__footer">
                        <!--<div class="kt-widget__wrapper">
                            <div class="kt-widget__section">
                                <div class="kt-widget__blog">
                                    <i class="flaticon2-list-1"></i>
                                    <a href="#" class="kt-widget__value kt-font-brand">56 Tasks</a>
                                </div>

                                <div class="kt-widget__blog">
                                    <i class="flaticon2-talk"></i>
                                    <a href="#" class="kt-widget__value kt-font-brand">745 Comments</a>
                                </div>
                            </div>

                            <div class="kt-widget__section">
                                <button type="button" class="btn btn-brand btn-sm btn-upper btn-bold">details</button>      
                            </div>
                        </div>-->
                    </div>
                </div>
                <!--end::Widget -->
            </div>
        </div>
        <!--end:: Portlet-->
    </div>   
</div>
<!--End::Section-->
    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/dashboard.js')}}" type="text/javascript"></script>
@endsection
@endsection
