$(document).ready(function() {
    $('.users-table').each(function () {
        $(this).dataTable(window.dtDefaultOptions);
    });
    var dataTable = $('#users-table').dataTable({
        processing: true,
        serverSide: true,
        language: {
            "url": url + "assets/vendors/general/datatables/Spanish.json"
        },
        ajax: {
            "url": url + "admin/data_listar_inventario",
            "type": "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'apellido_paterno', name: 'apellido_paterno' },
            { data: 'apellido_materno', name: 'apellido_materno' },
            { data: 'usuario', name: 'usuario' },
            { data: 'email', name: 'email' },
            {
                "mRender": function (data, type, row) {
                    var id_user = row.id;
                    return '<a class="btn btn-cdmx" onClick="edit_user_modal('+id_user+');" href="javascript:void(0)">Editar</a>';
                }
            }

        ]
        });
});

// Mostrar modal para alta de usuario
function create_seccion() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/create_seccion",
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#mod_add_seccion")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
// Guardar nuevo rol
function save_seccion() {
    console.log("dededed");
    if(!formValidate('#frm_new_rol')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/save_seccion",
        type: 'POST',
        data: $("#desc_seccion").serialize(),
        dataType: 'json',
        success: function(response) {

            console.log(response);
            if (response.resp == true) {
                destroyModal('mod_add_seccion');
                Swal.fire('¡Correcto!',response.message,'success');
                $("#table-roles-permisos").load(" #table-roles-permisos");
            } else {
                Swal.fire('error', response.message,"error");
            }
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}
// Guardar nuevo usuario
function save_user_create() {
    if(!formValidate('#frm_nuevo_usuario')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/store",
        type: 'POST',
        data: $("#frm_nuevo_usuario").serialize(),
        dataType: 'json',
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#mod_add_user').modal('hide').on('hidden.bs.modal', function() {
                    Swal.fire("Proceso  correcto!", "Se  creó  correctamente  el usuario!","success");
                    $('#users-table').DataTable().ajax.reload();
                });
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');

        }
    });
}

// Mostrar modal para edición de usuario
function edit_user_modal(data) {

    var id=data;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/edit",
        dataType: 'html',
        data:{
            id:id
        },
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {

                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#mod_edit_user")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-03','warning');
        }
    });
}

function edit_user() {
    if(!formValidate('#editar_usuario')){ return false; }
    var password = $('#password').removeClass('has-error').val();
    var password2 = $('#password2').removeClass('has-error').val();
    if (password != password2){
        showElementError('password2','Las contraseñas no son iguales.');
        return false;
    }
    var dataString = ($("#editar_usuario").serialize());
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/update",
        type: 'POST',
        data: dataString,
        dataType: 'json',
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#mod_edit_user').modal('hide').on('hidden.bs.modal', function() {
                    Swal.fire("Proceso  correcto!", "Se  modifico  correctamente  el usuario!","success");
                    $('#users-table').DataTable().ajax.reload();
                });
            }else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}
// Mostrar modal para alta de rol
function add_new_rol() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/create_rol",
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}

//$(".dt-buttons").addClass('kt-hidden');
