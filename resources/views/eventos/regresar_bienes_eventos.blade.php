@extends('home')
@section('content')
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-08-25-063451/theme/html/demo1/dist/../src/media/svg/icons/Tools/Tools.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
   


            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                    <path d="M9,10 L9,19 L5,19 L5,10 L5,6 L18,6 L18,10 L9,10 Z" id="Combined-Shape" fill="#000000" transform="translate(11.500000, 12.500000) scale(-1, 1) translate(-11.500000, -12.500000) "/>
                    <circle id="Oval" fill="#000000" opacity="0.3" cx="8" cy="16" r="2"/>
                </g>
            </svg>


            </svg><!--end::Svg Icon--></span>
            <h3 class="kt-portlet__head-title">
                Entrada de Bienes de un Evento
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <!--<div class="kt-portlet__head-actions">
                    
                    &nbsp;
                    <a href="javascript:void(0);" onclick="create_seccion();" class="btn btn-cdmx btn btn-brand btn-elevate">
                        <i class="la la-plus"></i>
                       Agregar Sección
                    </a>

                </div>-->
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <form role="form" name="frm_retorno_de_evento" id="frm_retorno_de_evento" method="POST" accept-charset="UTF-8" 
                enctype="multipart/form-data">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">
                                                    Seleccionar Evento
                                                </h3>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            {{ Form::label('evento', 'Evento', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                            <select class="form-control selectpicker" id="evento" name="evento">
                                                    <option value="0">Elige</option>
                                            </select> 
                                            </div>
                                        </div>
                                        <div id="boxNumber">
                                            <div class="form-group row">
                                            {{ Form::label('boxNumberInput', 'Cantidad Número', array('class' => 'col-xl-3 col-form-label')) }}
                                                <div class="col-xl-3">
                                                    {{ Form::number('boxNumberInput', auth()->user()->codigoInvent, array('class' => 'form-control')) }}
                                                </div>
                                                <div class="col-xl-3">
                                                    
                                                    <input class="form-control" type="number" id="inputRestar" 
                                                    name="inputRestar" readonly="readonly" style="background: #DCDCDC;">
                                                </div>
                                            </div>
                                        
                                        </div>

                                        <div class="form-group row">
                                            {{ Form::label('observaciones', 'Observaciones', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                
                                                <input type="text" class="form-control" value="Obs." name="observaciones" id="observaciones">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('estado_fisico', 'Estado Físico', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                <select class="form-control selectpicker" 
                                                id="estado_fisico" name="estado_fisico">
                                                    <option value="1">Bueno</option>
                                                    <option value="2">Regular</option>
                                                    <option value="3">Malo</option>
                                            </select> 
                                            </div>
                                        </div>
                                        
                                         <div class="form-group row">
                                            {{ Form::label('codigoInvent', 'Código Inventario', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::number('codigoInvent', auth()->user()->codigoInvent, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                         
                                       
                                        <div class="card-body px-3 pt-2">
                                            <div class="form-group row align-items-center">
                                            </div>
                                        </div>
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-xl-3"></div>
                                                <div class="col-lg-9 col-xl-6">        

                                                    <button type="submit" id="acciones" class="btn btn-success" >Guardar</button>                                            
                                                    
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>

                        <!---->
                        <!---->
                        <!---->
                        <!---->
                        <!---->
                         <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                <!--begin: Datatable -->
                                <div class="table-responsive col-xl-12"> 
                                    <table class="table table-striped- table-bordered table-hover table-checkable" id="bienes-evento-table">
                                    <thead>
                                    <tr>
                                        <th> ID </th>
                                        <th> Nro. </th>
                                        <th> Sección </th>
                                        <th> Bien </th>
                                        <th> Observaciones </th>
                                        <th> Fecha </th>
                                        <th> Estado Fisico </th>
                                        <th> Conteo </th>
                                        <th> Acciones</th>
                                    </tr>
                                    </thead>


                                </table>
                            </div>
                                <!--end: Datatable -->
                                </div>
                            </div>


    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/eventos.js')}}" type="text/javascript"></script>
@endsection
@endsection
