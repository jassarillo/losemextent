$(document).ready(function() {
    $("#boxNumber").hide();

    $('.inventarios-table').each(function () {
        $(this).dataTable(window.dtDefaultOptions);
    });
    var dataTable = $('#empleados-table').dataTable({

        processing: true,
        serverSide: true,
        language: {
            "url": url + "assets/vendors/general/datatables/Spanish.json"
        },
        ajax: {
            "url": url + "admin/data_listar_empleados",
            "type": "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nro_empleado', name: 'nro_empleado' },
            { data: 'nombre_completo', name: 'nombre_completo' },
            { data: 'status', name: 'status' },
            { data: 'edad', name: 'edad' },
            { data: 'telefono', name: 'telefono' },
            {
                "mRender": function (data, type, row) {
                    return '<a onclick="get_data_edit_empleado('+ row.id +');" href="#'+row.id+'" class="btn btn-primary" data-toggle="modal" data-target="#kt_modal_KTDatatable_local" >Editar</a>';
                }
            },
            {
                "mRender": function (data, type, row) {
                    return '<a onclick="eliminar_empleado('+ row.id +');" href="#'+row.id+'" class="btn btn-danger" data-toggle="modal" data-target="#kt_modal_KTDatatable_local" >Editar</a>';
                }
            }
        ]
        });
    

  

   

        // Salida nuevo Bien a evento
$('#frm_nuevo_evento').on('submit', function(e) {
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
        url: "admin/addItemEvent",
        data: formData, 
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            //console.log(respuesta.resp);
            

            
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');

        }
    });
});


        // Retorno bien de un evento



eliminar_bien_evento = function (idEmpleado){
    console.log(idInvent);
inputRestar =1;
    evento=$("#evento").val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/eliminar_bien_evento/"+ evento+"/"+id_clasifica+"/"+
                id_bien+"/"+unico+"/"+conteo+"/"+idInvent+"/"+inputRestar,
        dataType: 'html',
        success: function(respuesta) {
                    var obj = jQuery.parseJSON( respuesta );
                    //console.log(obj.resp);
                    if(obj.resp == true) {
                        //console.log(666);
                       reloadDataTableEventSend();
                            Swal.fire("Proceso  correcto!", "Registro removido!","success");
                    } else {
                        Swal.fire('error', respuesta.message,"error");
                    }
                },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
};



});//Fin Document Ready

function get_data_edit_empleado(idEmpleado) {
    //console.log(id_event);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/get_data_edit_empleado/"+ idEmpleado,
        dataType: 'html',
        success: function(data) {
            //console.log(data);
            var obj = jQuery.parseJSON( data );
            //console.log(data);
            $("#nro_empleado_e").val(obj[0]['nro_empleado']);
            $("#direccion_e").val(obj[0]['direccion']);
            $("#edad_e").val(obj[0]['edad']);
            $("#email_e").val(obj[0]['email']);
            $("#nombre_completo_e").val(obj[0]['nombre_completo']);
            $("#telefono_e").val(obj[0]['telefono']); 
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
};

function mayus(e) {
        e.value = e.value.toUpperCase();
     };
