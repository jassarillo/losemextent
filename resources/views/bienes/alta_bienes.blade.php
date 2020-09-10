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
               Alta Bienes
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <!--<div class="dropdown dropdown-inline">
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
                    </div>-->
                    &nbsp;
                    <a href="javascript:void(0);" onclick="create_seccion();" class="btn btn-cdmx btn btn-brand btn-elevate">
                        <i class="la la-plus"></i>
                       Agregar Sección
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">


 <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1" role="tab">
                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-08-25-063451/theme/html/demo1/dist/../src/media/svg/icons/General/Duplicate.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M15.9956071,6 L9,6 C7.34314575,6 6,7.34314575 6,9 L6,15.9956071 C4.70185442,15.9316381 4,15.1706419 4,13.8181818 L4,6.18181818 C4,4.76751186 4.76751186,4 6.18181818,4 L13.8181818,4 C15.1706419,4 15.9316381,4.70185442 15.9956071,6 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                            <path d="M10.1818182,8 L17.8181818,8 C19.2324881,8 20,8.76751186 20,10.1818182 L20,17.8181818 C20,19.2324881 19.2324881,20 17.8181818,20 L10.1818182,20 C8.76751186,20 8,19.2324881 8,17.8181818 L8,10.1818182 C8,8.76751186 8.76751186,8 10.1818182,8 Z" fill="#000000"/>
                        </g>
                    </svg><!--end::Svg Icon--></span> Agregar Bien
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_3" role="tab">
                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-08-25-063451/theme/html/demo1/dist/../src/media/svg/icons/Text/Bullet-list.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" fill="#000000"/>
                                <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" fill="#000000" opacity="0.3"/>
                            </g>
                            </svg><!--end::Svg Icon--></span> Bienes
                        </a>
                    </li>

                   
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            
                <div class="tab-content">
                    <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                            <form role="form" name="frm_nuevo_bien" id="frm_nuevo_bien" method="POST" accept-charset="UTF-8" 
                enctype="multipart/form-data">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Capturar Datos de un Bien
                                                        </h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('id_clasificacion', 'Clasificación', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                    <select class="selectpicker form-control" id="id_clasificacion" name="id_clasificacion" ata-show-subtext="true" data-live-search="true">
                                                        <option value="0">Seleccione</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('descripcion', 'Descripcion', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('descripcion', auth()->user()->descripcion, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('causa_alta', 'Causa de Alta', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                              <select class="form-control" id="causa_alta" name="causa_alta">
                                                        <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('fecha_alta', 'Fecha de Alta', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::date('fecha_alta', auth()->user()->fecha_alta, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('estado', 'Estado', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                    <select class="form-control" id="estado" name="estado">
                                                        <option value="1">Bueno</option>
                                                        <option value="2">Regular</option>
                                                        <option value="3">Malo</option>
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"> </div>
                                    <!-- -------------------MEDIDAS----------------------------- -->
                                    <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Medidas
                                                        </h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('largo', 'Largo', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('largo', auth()->user()->largo, array('class' => 'form-control')) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {{ Form::label('ancho', 'Ancho', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('ancho', auth()->user()->ancho, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('alto', 'Alto', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('alto', auth()->user()->alto, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('diametro', 'Diametro', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('diametro', auth()->user()->diametro, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('peso', 'Peso', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('peso', auth()->user()->peso, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('calibre', 'Calibre', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('calibre', auth()->user()->calibre, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('uso_material', 'Uso de Material', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                    <select class="form-control" id="uso_material" name="uso_material">
                                                        <option value="0">Seleccione</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="card-body px-3 pt-2">
                                        <div class="form-group row align-items-center">
                                            <div class="col-auto">

                                                <label for="customFile" class="col-form-label">Adjuntar Imagen</label>
                                            </div>
                                            <div class="col-sm-9 col-md-9 col-lg-7 col-xl-7">
                                                    <input class="col-12 pl-0 pr-0 pt-0 pb-0 btn border " type="file" name="anexo_1" id="anexo_1" style="background-color: white">
                                                    <label for="archivo"></label>
                                            </div>
                                             <div class="col-1" align="center"></div>
                                        </div>
                            <div class="form-group row align-items-center">
                            </div>
                        </div>
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-xl-3"></div>
                                                <div class="col-lg-9 col-xl-6">        

                                                    <button type="submit" id="acciones" class="btn btn-success" >Guardar</button>                                            
                                                    <!--<button type="button" class="btn btn-cdmx swal2-center" id="usr_js_fn_00" 
                                                    onclick="save_bien();">
                                                        Agregar
                                                    </button>-->
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="tab-pane" id="kt_user_edit_tab_3" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                        {{ Form::open(['url' => 'foo/bar','method' => 'POST','name'=>'form_update_passwd','id'=>'form_update_passwd']) }}
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                <!--begin: Datatable -->
                                <div class="table-responsive col-xl-12"> 
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
                                        <th> Foto</th>
                                        <!--<th> Usu de MAterias*?</th>-->
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                                <!--end: Datatable -->
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid">
                            </div>

                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-xl-3"></div>
                                    <div class="col-lg-9 col-xl-6">

                                    <!--<button type="submit" class="btn btn-brand">Guardar</button>-->
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    

                </div>
            
        </div>




    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/bienes.js')}}" type="text/javascript"></script>
@endsection
@endsection
