<!-- modal editar -->
            <!-- local datatable modal -->
<div id="kt_modal_KTDatatable_local" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="min-height: 590px;">
            <div class="modal-header">
                <h5 class="modal-title">
                   Editar Evento
                    
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--begin: Search Form -->
                
    <div class="row align-items-center">
        <div class="col-xl-8 order-2 order-xl-1">
                
                <form role="form" name="frm_edit_empleado" id="frm_edit_empleado" method="POST" accept-charset="UTF-8" 
                enctype="multipart/form-data">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                     
                                       <input type="hidden" name="id_update" id="id_update">
                                        <div class="form-group row">
                                            {{ Form::label('nro_empleado_e', 'Nro. Empleado', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                    <input type="text" name="nro_empleado_e" id="nro_empleado_e" class="form-control" onkeyup="mayus(this);">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            {{ Form::label('nombre_completo_e', 'Nombre y Apellido:', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('nombre_completo_e', auth()->user()->nombre_completo_e, array('class' => 'form-control')) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">  
                                            {{ Form::label('direccion_e', 'Dirección', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control" type="text" value="13:45:00" id="direccion_e" name="direccion_e">
                                            </div>
                                        </div>
                                        

                                    
                                        <div class="form-group row">
                                            {{ Form::label('telefono_e', 'Teléfono', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                
                                                <input type="text" name="telefono_e" id="telefono_e" class="form-control" onkeyup="mayus(this);">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {{ Form::label('email_e', 'Correo Electrónico', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('email_e', auth()->user()->email_e, array('class' => 'form-control')) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {{ Form::label('edad_e', 'Edad', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text" name="edad_e" id="edad_e" class="form-control" onkeyup="mayus(this);">
                                            </div>
                                        </div>
                                  
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-xl-3"></div>
                                                <div class="col-lg-9 col-xl-6">        

                                                    <input type="submit" class="btn btn-cdmx" name="Actualizar">                                          
                                                
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