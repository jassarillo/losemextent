@extends('home')
@section('content')
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-08-25-063451/theme/html/demo1/dist/../src/media/svg/icons/Tools/Tools.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
   





<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect id="bound" x="0" y="0" width="24" height="24"/>
        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" id="Combined-Shape" fill="#000000"/>
        <rect id="Rectangle-152" fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"/>
        <rect id="Rectangle-152-Copy-2" fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"/>
        <rect id="Rectangle-152-Copy-3" fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"/>
        <rect id="Rectangle-152-Copy" fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"/>
        <rect id="Rectangle-152-Copy-5" fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"/>
        <rect id="Rectangle-152-Copy-4" fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"/>
    </g>
</svg>


</svg><!--end::Svg Icon--></span>
            <h3 class="kt-portlet__head-title">
               Buscador por código de barras
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


    <div class="tab-pane" id="kt_user_edit_tab_3" role="tabpanel">
            <div class="kt-form kt-form--label-right">
            
                <div class="kt-form__body">
                    <div class="kt-section kt-section--first">
                    <!-- solo buscador -->
                        <div class="table-responsive col-xl-12"> 
                            <div class="form-group row">
                                {{ Form::label('nro_invent', 'Buscar por Código:', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                <div class="col-lg-9 col-xl-6">
                                        <input type="text" name="nro_invent" id="nro_invent" class="form-control" >
                                </div>
                            </div>



                        </div>
                    <!-- solo buscador -->


                    <!-- form ver datos-->
                        <div class="row align-items-center">
                            <div class="col-xl-8 order-2 order-xl-1">
                                   
                                    
                    <form role="form" name="frm_edit_bien" id="frm_edit_bien" method="POST" accept-charset="UTF-8" 
                    enctype="multipart/form-data">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                         
                                            <!--<div class="form-group row">
                                                {{ Form::label('id_clasificacion', 'Clasificación', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-9 col-xl-6">
                                                        <select class="selectpicker form-control" id="id_clasificacion" name="id_clasificacion" ata-show-subtext="true" data-live-search="true">
                                                            <option value="0">Seleccione</option>
                                                        </select>
                                                </div>
                                            </div>-->
                                            <input type="hidden" name="id_update" id="id_update">
                                            <div class="form-group row">
                                                {{ Form::label('descripcion_e', 'Descripcion', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-9 col-xl-6">
                                                    <input type="text" class="form-control"  name="descripcion_e" id="descripcion_e" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('causa_alta_e', 'Causa de Alta', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-9 col-xl-6">
                                                  <select class="form-control" id="causa_alta_e" name="causa_alta_e">
                                                           
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('fecha_alta_e', 'Fecha de Alta', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-9 col-xl-6">
                                                    {{ Form::date('fecha_alta_e', auth()->user()->fecha_alta_e, array('class' => 'form-control')) }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('estado_e', 'Estado', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-9 col-xl-6">
                                                        <select class="form-control" id="estado_e" name="estado_e">
                                                            
                                                            <option value="1">Bueno</option>
                                                            <option value="2">Regular</option>
                                                            <option value="3">Malo</option>
                                                        </select>
                                                </div>
                                            </div>

                                            <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"> </div>
                                        <!-- -------------------MEDIDAS----------------------------- -->
                                        <!-- -------------------MEDIDAS----------------------------- -->
                                        <!-- -------------------MEDIDAS----------------------------- -->
                                        <div class="row">
                                                <label class="col-xl-3"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <h3 class="kt-section__title kt-section__title-sm">Medidas
                                                            </h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('largo_e', 'Largo', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-4 col-xl-3">
                                                    {{ Form::text('largo_e', auth()->user()->largo_e, array('class' => 'form-control')) }}
                                                </div>
                                                <div class="col-lg-4 col-xl-3">
                                                    <select class="form-control" id="largo_e_medida" name="largo_e_medida">
                                                        <option value="0">Elige</option>
                                                        <option value="1">Milimetros</option>
                                                        <option value="2">Centímetros</option>
                                                        <option value="3">Pulgadas</option>
                                                        <option value="4">Metros</option>
                                                        <option value="5">Inches</option>
                                                        <option value="6">Yardas</option>
                                                        <option value="7">Brazadas</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                {{ Form::label('ancho_e', 'Ancho', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-4 col-xl-3">
                                                    {{ Form::text('ancho_e', auth()->user()->ancho_e, array('class' => 'form-control')) }}
                                                </div>
                                                <div class="col-lg-4 col-xl-3">
                                                    <select class="form-control" id="ancho_e_medida" name="ancho_e_medida">
                                                        <option value="0">Elige</option>
                                                        <option value="1">Milimetrsos</option>
                                                        <option value="2">Centímetros</option>
                                                        <option value="3">Pulgadas</option>
                                                        <option value="4">Metros</option>
                                                        <option value="5">Inches</option>
                                                        <option value="6">Yardas</option>
                                                        <option value="7">Brazadas</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('alto_e', 'Alto', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-4 col-xl-3">
                                                    {{ Form::text('alto_e', auth()->user()->alto_e, array('class' => 'form-control')) }}
                                                </div>
                                                <div class="col-lg-4 col-xl-3">
                                                    <select class="form-control" id="alto_e_medida" name="alto_e_medida">
                                                        <option value="0">Elige</option>
                                                        <option value="1">Milimetros</option>
                                                        <option value="2">Centímetros</option>
                                                        <option value="3">Pulgadas</option>
                                                        <option value="4">Metros</option>
                                                        <option value="5">Inches</option>
                                                        <option value="6">Yardas</option>
                                                        <option value="7">Brazadas</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('diametro_e', 'Diametro', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-4 col-xl-3">
                                                    {{ Form::text('diametro_e', auth()->user()->diametro_e, array('class' => 'form-control')) }}
                                                </div>
                                                <div class="col-lg-4 col-xl-3">
                                                    <select class="form-control" id="diametro_e_medida" name="diametro_e_medida">
                                                        <option value="0">Elige</option>
                                                        <option value="1">Milimetros</option>
                                                        <option value="2">Centímetros</option>
                                                        <option value="3">Pulgadas</option>
                                                        <option value="4">Metros</option>
                                                        <option value="5">Inches</option>
                                                        <option value="6">Yardas</option>
                                                        <option value="7">Brazadas</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('peso_e', 'Peso', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-4 col-xl-3">
                                                    {{ Form::text('peso_e', auth()->user()->peso_e, array('class' => 'form-control')) }}
                                                </div>
                                                <div class="col-lg-4 col-xl-3">
                                                    <select class="form-control" id="peso_e_medida" name="peso_e_medida">
                                                        <option value="0">Elige</option>
                                                        <option value="10">Miligramo</option>
                                                        <option value="11">CentíGramo</option>
                                                        <option value="12">Kilo</option>
                                                        <option value="13">Tonelada</option>
                                                        <option value="14">Libra</option>
                                                        <option value="15">Onza</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('calibre_e', 'Calibre', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-4 col-xl-3">
                                                    {{ Form::text('calibre_e', auth()->user()->calibre_e, array('class' => 'form-control')) }}
                                                </div>
                                                <div class="col-lg-4 col-xl-3">
                                                    <select class="form-control" id="calibre_e_medida" name="calibre_e_medida">
                                                        <option value="1">Milimetros</option>
                                                        <option value="2">Centímetros</option>
                                                        <option value="3">Pulgadas</option>
                                                        <option value="4">Metros</option>
                                                        <option value="5">Inches</option>
                                                        <option value="6">Yardas</option>
                                                        <option value="7">Brazadas</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('volumen_e', 'Volumen', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-4 col-xl-3">
                                                    {{ Form::text('volumen_e', auth()->user()->volumen_e, array('class' => 'form-control')) }}
                                                </div>
                                                <div class="col-lg-4 col-xl-3">
                                                    <select class="form-control" id="volumen_e_medida" name="volumen_e_medida">
                                                        <option value="0">Elige</option>
                                                        <option value="20">Litros</option>
                                                        <option value="21">Galones</option>
                                                        <option value="22">Centímetros Cúbicos</option>
                                                        <option value="23">Mili Litros</option>
                                                        <option value="24">Onzas</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{ Form::label('uso_material_e', 'Uso de Material', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                                <div class="col-lg-9 col-xl-6">
                                                        <select class="form-control" id="uso_material_e" name="uso_material_e">
                                                            <option value="0">Seleccione</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="card-body px-3 pt-2">
                                            
                                <div class="form-group row align-items-center">
                                </div>
                            </div>
                                          

                                        </div>
                                    </div>
                                </div>
                            </form>        
                            </div>
                          
                        </div>
                    <!-- form ver datos-->
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
                
            </div>
        </div>
       




    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/buscador.js')}}" type="text/javascript"></script>
@endsection
@endsection
