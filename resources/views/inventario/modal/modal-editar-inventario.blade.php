                <!-- modal editar -->
            <!-- local datatable modal -->
<div id="kt_modal_KTDatatable_local" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="min-height: 590px;">
            <div class="modal-header">
                <h5 class="modal-title">
                   Editar Elemento
                    
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--begin: Search Form -->
                
    <div class="row align-items-center">
        <div class="col-xl-8 order-2 order-xl-1">
               
                
                <form role="form" name="frm_edit_invent" id="frm_edit_invent" method="POST" accept-charset="UTF-8" 
                enctype="multipart/form-data">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Editar Inventario de un Bien
                                                        </h3>
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="form-group row">
                                            {{ Form::label('fecha_inventario_e', 'Fecha Inventario', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::date('fecha_inventario_e', auth()->user()->fecha_inventario_e, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('motivo_alta_e', 'Motivo de Alta', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                    <select class="form-control" id="motivo_alta_e" name="motivo_alta_e">
                                                        <option value="1">Inventario Inicial</option>
                                                        <option value="2">Reaprovechamiento</option>
                                                        <option value="3">Reclasificación</option>
                                                        <option value="4">Reposición</option>
                                                        <option value="5">Sustitución</option>
                                                        <option value="6">Transferencia</option>
                                                        <option value="7">Traspaso</option>
                                                    </select>
                                            </div>
                                        </div>

                                    
                                        <div class="form-group row">
                                            {{ Form::label('factura_e', 'Factura', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                
                                                <input type="text" name="factura_e" id="factura_e" class="form-control" onkeyup="mayus(this);">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {{ Form::label('precio_e', 'Precio', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::number('precio_e', auth()->user()->precio_e, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('conteo_e', 'Conteo', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="number" name="conteo_e" id="conteo_e" class="form-control">
                                            </div>
                                        </div>                                        
                                         <div class="form-group form-group-last row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Un registro
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <span class="kt-switch">
                                                    <label>
                                                        <input type="checkbox" name="unicoEdit" id="unicoEdit">
                                                        <span></span>
                                                    </label>
                                                </span>
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
                        </form>
        </div>
      
    </div>
             <!--end: Search Form -->
            </div>
            <div class="modal-body modal-body-fit">
                <!--begin: Datatable -->
                <div id="modal_datatable_local_source"></div>
                <!--end: Datatable -->
            </div>
            <div class="modal-footer kt-hidden">
                <button type="button" class="btn btn-clean btn-bold btn-upper btn-font-md" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default btn-bold btn-upper btn-font-md">Submit</button>
            </div>
        </div>
    </div>
</div>
        <!--modal editar -->