@extends('home')
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-xl-6">
            <!--begin:: Widgets/Support Cases-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-08-25-063451/theme/html/demo1/dist/../src/media/svg/icons/Tools/Tools.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
   


            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                   <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                       <polygon id="bound" points="0 0 24 0 24 24 0 24"/>
                       <path d="M11.2600599,5.81393408 L2,16 L22,16 L12.7399401,5.81393408 C12.3684331,5.40527646 11.7359848,5.37515988 11.3273272,5.7466668 C11.3038503,5.7680094 11.2814025,5.79045722 11.2600599,5.81393408 Z" id="Path-71" fill="#000000" opacity="0.3"/>
                       <path d="M12.0056789,15.7116802 L20.2805786,6.85290308 C20.6575758,6.44930487 21.2903735,6.42774054 21.6939717,6.8047378 C21.8964274,6.9938498 22.0113578,7.25847607 22.0113578,7.535517 L22.0113578,20 L16.0113578,20 L2,20 L2,7.535517 C2,7.25847607 2.11493033,6.9938498 2.31738608,6.8047378 C2.72098429,6.42774054 3.35378194,6.44930487 3.7307792,6.85290308 L12.0056789,15.7116802 Z" id="Combined-Shape" fill="#000000"/>
                   </g>
               </svg>


            </svg><!--end::Svg Icon--></span>
            <h3 class="kt-portlet__head-title">
               Filtro Etiquetas
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
                            <label>Nro.</label>
                            </div> 
                            <div class="col-xm-5">
                                    <select class="selectpicker form-control" id="nro_progresivo" name="nro_progresivo" data-show-subtext="true" data-live-search="true">
                                        <option value="0">Seleccione</option>
                                    </select>
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
                            Paginado de etiquetas <small></small>
                        </h3>
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
