@extends('home')
@section('content')
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-08-25-063451/theme/html/demo1/dist/../src/media/svg/icons/Tools/Tools.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M15.9497475,3.80761184 L13.0246125,6.73274681 C12.2435639,7.51379539 12.2435639,8.78012535 13.0246125,9.56117394 L14.4388261,10.9753875 C15.2198746,11.7564361 16.4862046,11.7564361 17.2672532,10.9753875 L20.1923882,8.05025253 C20.7341101,10.0447871 20.2295941,12.2556873 18.674559,13.8107223 C16.8453326,15.6399488 14.1085592,16.0155296 11.8839934,14.9444337 L6.75735931,20.0710678 C5.97631073,20.8521164 4.70998077,20.8521164 3.92893219,20.0710678 C3.1478836,19.2900192 3.1478836,18.0236893 3.92893219,17.2426407 L9.05556629,12.1160066 C7.98447038,9.89144078 8.36005124,7.15466739 10.1892777,5.32544095 C11.7443127,3.77040588 13.9552129,3.26588995 15.9497475,3.80761184 Z" fill="#000000"/>
        <path d="M16.6568542,5.92893219 L18.0710678,7.34314575 C18.4615921,7.73367004 18.4615921,8.36683502 18.0710678,8.75735931 L16.6913928,10.1370344 C16.3008685,10.5275587 15.6677035,10.5275587 15.2771792,10.1370344 L13.8629656,8.7228208 C13.4724413,8.33229651 13.4724413,7.69913153 13.8629656,7.30860724 L15.2426407,5.92893219 C15.633165,5.5384079 16.26633,5.5384079 16.6568542,5.92893219 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>
            <h3 class="kt-portlet__head-title">
               Inventario
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <div class="dropdown dropdown-inline">
                        <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="la la-download"></i> Exportar
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="kt-nav dt_export">
                                <li class="kt-nav__section kt-nav__section--first">
                                    <span class="kt-nav__section-text">Selecciona...</span>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link"  data-value="0">
                                        <i class="kt-nav__link-icon la la-copy"></i>
                                        <span class="kt-nav__link-text">Copiar</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link"  data-value="1">
                                        <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                        <span class="kt-nav__link-text">Excel</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link"  data-value="2">
                                        <i class="kt-nav__link-icon la la-file-text-o"></i>
                                        <span class="kt-nav__link-text">CSV</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link"  data-value="3">
                                        <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                        <span class="kt-nav__link-text">PDF</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link" data-value="4">
                                        <i class="kt-nav__link-icon la la-print"></i>
                                        <span class="kt-nav__link-text">Imprimir</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    &nbsp;
                    <a href="javascript:void(0);" onclick="add_user_modal();" class="btn btn-cdmx btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i>
                       Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="users-table">
            <thead>
            <tr>
                <th> ID </th>
                <th> Clasificación </th>
                <th> Descripción </th>
                <th> Causa de Alta </th>
                <th> Fecha Ala </th>
                <th> Estado </th>
                <th> Largo</th>
                <th> Ancho</th>
                <th> Alto</th>
                <th> Diametro</th>
                <th> Peso</th>
                <!--<th> Litros</th>-->
                <th> Ver Foto</th>
                <th> Usu de MAterias*?</th>
            </tr>
            </thead>


        </table>
        <!--end: Datatable -->
    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/inventario.js')}}" type="text/javascript"></script>
@endsection
@endsection
