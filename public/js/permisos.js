$(document).ready(function() {
    $('#table-roles-permisos').dataTable({
        "searching": false,
        "ordering": false,
        "lengthChange": false
    });
});

//Modal para agregar permiso
function add_new_permiso() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/create_permiso",
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

//Modal para agregar permiso
function edit_permiso(id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/permiso/"+id+"/editar_permiso_modal",
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

// Guardar nuevo permiso
function edit_permiso_store(id) {
    if(!formValidate('#frm_edit_permiso')){ return false; };
    var form = new FormData($("#frm_edit_permiso")[0]);
    form.append('id', id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/permiso/editar_permiso",
        type: 'POST',
        data: form,
        dataType: 'json',
        contentType: false,
		processData: false, 
        success: function(response) {
            if (response.success == true) {
                destroyModal('mod_edit_permiso');
                Swal.fire('¡Correcto!',response.message,'success');
                window.location.reload();
                //$("#table-roles-permisos").load(" #table-roles-permisos");
            } else {
                Swal.fire('error', response.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}


// Guardar nuevo permiso
function save_permiso_create() {
    if(!formValidate('#frm_new_permiso')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/store_new_permiso",
        type: 'POST',
        data: $("#frm_new_permiso").serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success == true) {
                destroyModal('mod_add_permiso');
                Swal.fire('¡Correcto!',response.message,'success');
                window.location.reload();
                //$("#table-roles-permisos").load(" #table-roles-permisos");
            } else {
                Swal.fire('error', response.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}