@extends('home')
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-xl-6">
            <!--begin:: Widgets/Support Cases-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Filtros Etiquetas<small>Baja de precio</small>
                        </h3>
                    </div>
                    
                    <!--<div class="kt-portlet__head-toolbar">
                    <a href="#" class="btn btn-label-success btn-bold btn-sm dropdown-toggle"
                            data-toggle="dropdown">
                            Herramientas
                        </a>
                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
                            
                        </div>
                    </div>-->
                </div>
                <div class="kt-portlet__body">
                    
                        <!-- Aqui van filtros Etiquetas-->

                        
                           <div class="col-xm-6">
                            <label>Secciones</label>
                           </div> 
                            <div class="col-xm-5">
                                   <select class="selectpicker form-control" id="id_clasifica" name="id_clasifica" data-show-subtext="true" data-live-search="true">
                                                        <option value="0">Seleccione</option>
                                    </select>
                            </div>

                            <div class="col-xm-6">
                            <label>Bienes</label>
                            </div> 
                            <div class="col-xm-5">
                                    <select class="selectpicker form-control" id="id_bien" name="id_bien" data-show-subtext="true" data-live-search="true">
                                        <option value="0">Seleccione</option>
                                    </select>
                            </div>

                            <div class="col-xm-6">
                                <!---->
                            </div> 

                       
                            <div><hr color="#00b140" class="mb-2"></div>
                        <!-- Aqui van filtros Etiquetas -->
                        

                </div>
            </div>
            <!--end:: Widgets/Support Stats-->
        </div>
        <div class="col-xl-6">
            <!--begin:: Widgets/Support Requests-->
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
                            <!--begin::Nav-->
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
                            <!--end::Nav-->
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-widget16">
                    <table class="table table-striped- table-bordered table-hover table-checkable"
                        id="pages-table">
                        <thead>
                            <tr>
                                <th> No. Pagina</th>
                                <th> Rango</th>
                                <th> Imprimir página </th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Support Requests-->
        </div>
    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/etiquetas.js')}}" type="text/javascript"></script>
@endsection
@endsection
