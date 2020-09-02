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
            "url": url + "admin/data_listar_bienes",
            "type": "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'id_clasificacion', name: 'id_clasificacion' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'causa_alta', name: 'causa_alta' },
            { data: 'fecha_alta', name: 'fecha_alta' },
            { data: 'estado', name: 'estado' },
            { data: 'largo', name: 'largo' },
            { data: 'ancho', name: 'ancho' },
            { data: 'alto', name: 'fecha_alta' },
            { data: 'diametro', name: 'fecha_alta' },
            { data: 'peso', name: 'peso' },
            /*{
                "mRender": function (data, type, row) {
                    var id_user = row.id;
                    return '<a class="btn btn-cdmx" onClick="edit_user_modal('+id_user+');" href="javascript:void(0)">Editar</a>';
                }
            }*/

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
// Guardar nueva seccion
function save_seccion() {
    //console.log("dededed");
    if(!formValidate('#frm_new_seccion')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/save_seccion",
        type: 'POST',
        data: $("#desc_seccion").serialize(),
        dataType: 'json',
        success: function(response) {

            //console.log(response);
            if (response.resp == true) {
                destroyModal('mod_add_seccion');
                Swal.fire('¡Correcto!',response.message,'success');
                //$("#table-roles-permisos").load(" #table-roles-permisos");
                getSelectSeccion();
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

function save_causa_alta() {
    //console.log("dededed");
    if(!formValidate('#frm_new_causa_alta')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/save_causa_alta",
        type: 'POST',
        data: $("#desc_causa_alta").serialize(),
        dataType: 'json',
        success: function(response) {

            //console.log(response);
            if (response.resp == true) {
                destroyModal('mod_add_seccion');
                Swal.fire('¡Correcto!',response.message,'success');
                $("#table-roles-permisos").load(" #table-roles-permisos");
                getSelectCausaAlta();
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

function save_uso() {
    //console.log("dededed");
    if(!formValidate('#frm_new_uso')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/save_uso",
        type: 'POST',
        data: $("#desc_uso").serialize(),
        dataType: 'json',
        success: function(response) {

            //console.log(response);
            if (response.resp == true) {
                destroyModal('mod_add_seccion');
                Swal.fire('¡Correcto!',response.message,'success');
                $("#table-roles-permisos").load(" #table-roles-permisos");
                getSelectUso();
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



function getSelectSeccion() {
    $(".optInvent").remove();
    $.ajax({
        type: "GET",
        url :  "admin/listSeccion",
        dataType: "json",
        success: function (data)
                        {
                            //console.log(data[0]);
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#id_clasificacion').append(
                                   '<option class="optInvent" value="' + opt.id + '"> ' + opt.id +" "+ opt.descripcion+'</option> '
                                );
                            });
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
getSelectSeccion()

function getSelectCausaAlta() {
    $(".optCatAlta").remove();
    $.ajax({
        type: "GET",
        url :  "admin/getSelectCausaAlta",
        dataType: "json",
        success: function (data)
                        {
                            //console.log(data[0]);
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#causa_alta').append(
                                   '<option class="optCatAlta" value="' + opt.id + '"> ' + opt.id +" "+ opt.descripcion+'</option> '
                                );
                            });
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
getSelectCausaAlta();

function getSelectUso() {
    $(".optCatUso").remove();
    $.ajax({
        type: "GET",
        url :  "admin/getSelectCatUso",
        dataType: "json",
        success: function (data)
                        {
                            //console.log(data[0]);
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#uso_material').append(
                                   '<option class="optCatUso" value="' + opt.id + '"> ' + opt.id +" "+ opt.descripcion+'</option> '
                                );
                            });
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
getSelectUso();

// Guardar nuevo Bien
function save_bien() {
    if(!formValidate('#frm_nuevo_bien')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/storeBien",
        type: 'POST',
        data: $("#frm_nuevo_bien").serialize(),
        dataType: 'json',
        success: function(respuesta) {
            //console.log(respuesta.resp);
            if (respuesta.resp == true) {
                //console.log(666);
               
                    Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success");
                   $('#users-table').DataTable().ajax.reload();
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
