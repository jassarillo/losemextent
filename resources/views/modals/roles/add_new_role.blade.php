<div class="modal fade" id="mod_add_rol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Añadir nuevo Rol:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_content">
                <div id="error_usuario_add"></div>
                <form role="form" name="frm_new_rol" id="frm_new_rol" method="POST">
                {{ csrf_field() }}
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="control-label">Nombre del Rol</label>
                                        <input type="text" class="form-control" id="rol" name="rol" placeholder="nombre del rol" required>
                                        <span id="usuario-error" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="error_alerta"> </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-cdmx swal2-center" id="usr_js_fn_04" onclick="save_role_create();">
                    Agregar
                </button>

            </div>
        </div>
    </div>
</div>
