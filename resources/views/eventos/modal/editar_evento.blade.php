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
               
                
                <form role="form" name="frm_edit_evento" id="frm_edit_evento" method="POST" accept-charset="UTF-8" 
                enctype="multipart/form-data">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                     
                                       <input type="hidden" name="id_update" id="id_update">
                                        <div class="form-group row">
                                            {{ Form::label('destino_e', 'Destino', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                    <input type="text" name="destino_e" id="destino_e" class="form-control" onkeyup="mayus(this);">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            {{ Form::label('fecha_e', 'Fecha', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::date('fecha_e', auth()->user()->fecha_e, array('class' => 'form-control')) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            
                                            {{ Form::label('hora_e', 'Hora', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control" type="time" value="13:45:00" id="hora_e" name="hora_e">
                                            </div>
                                        </div>
                                        

                                    
                                        <div class="form-group row">
                                            {{ Form::label('descripcion_e', 'Descripción', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                
                                                <input type="text" name="descripcion_e" id="descripcion_e" class="form-control" onkeyup="mayus(this);">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {{ Form::label('lugar_e', 'Lugar', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('lugar_e', auth()->user()->lugar_e, array('class' => 'form-control')) }}
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