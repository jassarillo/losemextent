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
               Existencias
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
                                <!--begin: Datatable -->
                                <div class="table-responsive col-xl-12"> 
                                    <table class="table table-striped- table-bordered table-hover table-checkable" id="existencias-table">
                                    <thead>
                                    <tr>
                                        <th> ID </th>
                                        <th> Bodega </th>
                                        <th> Id Clasifica </th>
                                        <th> Clasificación </th>
                                        <th> Id Bien </th>
                                        <th> Bien </th>
                                        <th> Conteo Existencia</th>
                                        <th> Fecha</th>
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
                            
                        </div>
                    </div>
       




    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/existencias.js')}}" type="text/javascript"></script>
@endsection
@endsection
