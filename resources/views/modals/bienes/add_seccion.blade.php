<div class="modal fade" id="mod_add_seccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Añadir Nueva Sección:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_content">
                <div id="error_usuario_add"></div>
                <form role="form" name="frm_new_seccion" id="frm_new_seccion" method="POST">
                {{ csrf_field() }}
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">Nombre de la Sección</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="desc_seccion" name="desc_seccion" placeholder="Sección" required>
                                        <span id="usuario-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label"></label>
                                    <button type="button" class="btn btn-cdmx swal2-center" id="usr_js_fn_04" onclick="save_seccion();">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="error_alerta"> </div>
                </form>
                <form role="form" name="frm_new_causa_alta" id="frm_new_causa_alta" method="POST">
                {{ csrf_field() }}
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">Causa Alta</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="desc_causa_alta" name="desc_causa_alta" placeholder="Causa Alta" required>
                                        <span id="usuario-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label"></label>
                                    <button type="button" class="btn btn-cdmx swal2-center" id="usr_js_fn_05" onclick="save_causa_alta();">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="error_alerta"> </div>
                </form>


                <form role="form" name="frm_new_uso" id="frm_new_uso" method="POST">
                {{ csrf_field() }}
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">Uso de Material</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="desc_uso" name="desc_uso" placeholder="Uso" required>
                                        <span id="usuario-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label"></label>
                                    <button type="button" class="btn btn-cdmx swal2-center" id="usr_js_fn_06" 
                                    onclick="save_uso();">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="error_alerta"> </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cerrar
                </button>
                

            </div>
        </div>
    </div>
</div>
