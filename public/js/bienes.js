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
            { data: 'idBien', name: 'idBien' },
            { data: 'secDesc', name: 'secDesc' },
            { data: 'bienesDesc', name: 'bienesDesc' },
            { data: 'descAlta', name: 'descAlta' },
            { data: 'fecha_alta', name: 'fecha_alta' },
            {
                "mRender": function (data, type, row) {
                    //var id_user = row.id;
                    estadoD='';
                    if(row.estado == 1 ){estadoD ='Bueno';}
                    else if(row.estado == 2){estadoD ='Regular';}
                    else if(row.estado == 3){estadoD ='Malo'; }
                    else{estadoD =''; }
                    return estadoD;
                }
            },
            //{ data: 'largo', name: 'largo' },
            {
                "mRender": function (data, type, row) {
                    
                    return row.largo+' '+row.largo_medidaD;
                }
            },
            {
                "mRender": function (data, type, row) {
                    
                    return row.ancho+' '+row.ancho_medidaD;
                }
            },
            //{ data: 'ancho', name: 'ancho' },
            {
                "mRender": function (data, type, row) {
                    
                    return row.alto+' '+row.alto_medidaD;
                }
            },
            //{ data: 'alto', name: 'fecha_alta' },
            //{ data: 'diametro', name: 'fecha_alta' },
            {
                "mRender": function (data, type, row) {
                    
                    return row.diametro+' '+row.diametro_medidaD;
                }
            },
            {
                "mRender": function (data, type, row) {
                    
                    return row.calibre+' '+row.calibre_medidaD;
                }
            },
            //{ data: 'peso', name: 'peso' },
            {
                "mRender": function (data, type, row) {
                    
                    return row.peso+' '+row.peso_medidaD;
                }
            },
            {
                "mRender": function (data, type, row) {
                    
                    return row.volumen+' '+row.volumen_medidaD;
                }
            },
            {
                "mRender": function (data, type, row) {
                    //var id_user = row.id;
                   
                    //return '<img width="80" height="95" class="img_avatar_header" alt="Pic" id="img_avatar_header" src="uploads/inventarios_img/20/'+row.idBien+'.jpg">';
                    return '<a onclick="modal_img_seccion('+ row.idBien +');" href="#'+row.idBien+'" class="btn btn-cdmx" data-toggle="modal" data-target="#kt_modal_imagen_local" >Editar</a>';

                }
            },
            {
                "mRender": function (data, type, row) {
                    var id_bien = row.idBien;
                    
                    //return '<button type="button" class="btn btn-brand" data-toggle="modal" data-target="#kt_modal_KTDatatable_local">Launch Modal</button>';
                    return '<a onclick="get_data_edit_seccion('+ id_bien +');" href="#'+id_bien+'" class="btn btn-cdmx" data-toggle="modal" data-target="#kt_modal_KTDatatable_local" >Editar</a>';
                }
            },
            /*{
                "mRender": function (data, type, row) {
                    var id_bien= row.idBien
                    return '<a class="btn btn-danger" onClick="deleteBien('+id_bien+');">Eliminar</a>';
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

//Editar Bien   *** *** ***
function editar_bien(id_bien) {
    console.log(id_bien);
}

function deleteBien(id_bien) {
    console.log(id_bien);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/deleteBien",
        type: 'POST',
        data: {'id_bien':id_bien},
        dataType: 'json',
        success: function(response) {
               
                Swal.fire('¡Correcto!',response.message,'success');
                $('#users-table').DataTable().ajax.reload();
               
           
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

//****---------->
function get_data_edit_seccion(id_bien) {
    console.log(id_bien);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/get_data_edit_seccion/"+ id_bien,
        dataType: 'html',
        success: function(data) {
            //console.log(data[0]['id']);
            var obj = jQuery.parseJSON( data );
            //getSelectCausaAlta_edit();

            getSelectCausaAlta_edit(obj[0]['causa_alta']);
            $("#id_update").val(obj[0]['id']);
            $("#descripcion_e").val(obj[0]['descripcion']);
            $("#fecha_alta_e").val(obj[0]['fecha_alta']);
            $("#estado_e").prop('selectedIndex', obj[0]['estado'] - 1);
            $("#largo_e").val(obj[0]['largo']);
            $("#largo_e_medida").prop('selectedIndex', obj[0]['largo_medida'] - 1);
            $("#ancho_e").val(obj[0]['ancho']);
            $("#ancho_e_medida").prop('selectedIndex', obj[0]['ancho_medida'] - 1);
            $("#alto_e").val(obj[0]['alto']);
            $("#alto_e_medida").prop('selectedIndex', obj[0]['alto_medida'] - 1);
            $("#diametro_e").val(obj[0]['diametro']);
            $("#diametro_e_medida").prop('selectedIndex', obj[0]['diametro_medida'] - 1);
            $("#peso_e").val(obj[0]['peso']);
            $("#peso_e_medida").prop('selectedIndex', obj[0]['peso_medida'] - 1);
            $("#calibre_e").val(obj[0]['calibre']);
            $("#calibre_e_medida").prop('selectedIndex', obj[0]['calibre_medida'] - 1);
            $("#volumen_e").val(obj[0]['volumen']);
            $("#volumen_e_medida").prop('selectedIndex', obj[0]['volumen_medida'] - 1);

            getSelectUso_edit(obj[0]['uso_material'] - 1);
            

            //$("#estado_e").val(obj[0]['estado']);

            //$("#causa_alta_e").prop('selectedIndex', 3);
            
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}

function getSelectCausaAlta_edit(causa_alta) {
    console.log(causa_alta);
    $(".optCatAlta_e").remove();
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
                                $('#causa_alta_e').append(
                                   '<option class="optCatAlta_e" value="' + opt.id + '"> ' + opt.id +" "+ opt.descripcion+'</option> '
                                );
                            });
                            $("#causa_alta_e").prop('selectedIndex', causa_alta - 5);

                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
};

function getSelectUso_edit(cau_uso) {
    $(".optCatUso_e").remove();
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
                                $('#uso_material_e').append(
                                   '<option class="optCatUso_e" value="' + opt.id + '"> ' + opt.id +" "+ opt.descripcion+'</option> '
                                );
                            });
                            $("#uso_material_e").prop('selectedIndex', cau_uso);
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
};
//Change Seccion
$('#id_clasificacion').on('change', function(){
    console.log("onchange selccion");
});

function getSelectSeccion() {
    $(".optInvent").remove();
    $.ajax({
        type: "GET",
        url :  "admin/listSeccion",
        dataType: "json",
        success: function (data)
                        { 
                            $(".selectpicker").selectpicker();
                            //console.log(data[0]);
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#id_clasificacion').append(
                                   '<option class="optInvent" value="' + opt.id_seccion + '"> ' + opt.id_seccion + ' ' +  opt.descripcion +'</option> '
                                );
                                $('.selectpicker').selectpicker('refresh');
                            });
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
getSelectSeccion();

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
$('#frm_nuevo_bien').on('submit', function(e) {
            e.preventDefault();
    var formData = new FormData(this);
    formData.append('_token', $('input[name=_token]').val());
    console.log(formData);
    if($("#id_clasificacion").val() == 0){
        alert("Falta Clasificación");
    }else if($("#descripcion").val() == "")
        alert("Falta campo Descipción");
    else{
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //url : url + "admin/storeBien",
                type: "POST",
                dataType: "json",
                url: "admin/storeBien",
                data: formData, 
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta) {
                    //console.log(respuesta.resp);
                    if (respuesta.resp == true) {
                        //console.log(666);
                       
                            Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success");
                           $('#users-table').DataTable().ajax.reload();
                           limpiarFormBienes();
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
});

 function limpiarFormBienes(){
    //id_clasificacion: 3
    $("#descripcion").val("");
    $("#causa_alta").val("");
    $("#fecha_alta").val("");
    $("#estado").val("");
    $("#largo").val("");
    $("#ancho").val("");
    $("#alto").val("");
    $("#diametro").val("");
    $("#peso").val("");
    $("#calibre").val("");
    $("#volumen").val("");
    $("#uso_material").val("");
    $("#uso_material").val("");
    $("#anexo_1").val("");

 }
  
    function save_bien() {
        console.log(4444);
    }


//Editar bien
$('#frm_edit_bien').on('submit', function(e) {
            e.preventDefault();
    var formData = new FormData(this);
    formData.append('_token', $('input[name=_token]').val());
    console.log(formData);
    
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //url : url + "admin/storeBien",
                type: "POST",
                dataType: "json",
                url: "admin/updateBien",
                data: formData, 
                cache: false,
                contentType: false,
                processData: false,
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
    

});

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

function mayus(e) {
        e.value = e.value.toUpperCase();
     };
//$(".dt-buttons").addClass('kt-hidden');
