$(document).ready(function() {
    $('.table-roles-permisos').each(function () {
        $(this).dataTable(window.dtDefaultOptions);
    });
    $('#table-roles-permisos').dataTable({
        "searching": false,
        "ordering": false,
        "lengthChange": false
    });
});

//Modal para agregar rol
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

// Guardar nuevo rol
function save_role_create() {
    if(!formValidate('#frm_new_rol')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/store_new_role",
        type: 'POST',
        data: $("#frm_new_rol").serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success == true) {
                destroyModal('mod_add_rol');
                Swal.fire('¡Correcto!',response.message,'success');
                $("#table-roles-permisos").load(" #table-roles-permisos");
            } else {
                Swal.fire('error', response.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}