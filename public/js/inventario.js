$(document).ready(function() {
    $('.inventarios-table').each(function () {
        $(this).dataTable(window.dtDefaultOptions);
    });
    var dataTable = $('#inventarios-table').dataTable({
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
            { data: 'descClasif', name: 'descClasif' },
            { data: 'descBien', name: 'descBien' },
            { data: 'motivo_alta', name: 'motivo_alta' },
            { data: 'factura', name: 'factura' },
            { data: 'precio', name: 'email' },
            { data: 'precio', name: 'email' },
            { data: 'precio', name: 'email' },
            { data: 'precio', name: 'email' },
            { data: 'precio', name: 'email' },
            {
                "mRender": function (data, type, row) {
                    var id_user = row.id;
                    return '<a class="btn btn-cdmx" onClick="edit_user_modal('+id_user+');" href="javascript:void(0)">Editar</a>';
                }
            }

        ]
        });
});

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
                                $('#id_clasifica').append(
                                   '<option class="optInvent" value="' + opt.id_seccion + '"> ' + opt.id_seccion +" "+ opt.descripcion+'</option> '
                                );
                            });
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
getSelectSeccion();

function getSelectBien() {
    $(".optInvent").remove();
    $.ajax({
        type: "GET",
        url :  "admin/listBienes",
        dataType: "json",
        success: function (data)
                        {
                            //console.log(data[0]);
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#id_bien').append(
                                   '<option class="optInvent" value="' + opt.id + '"> ' + opt.id +" "+ opt.descripcion+'</option> '
                                );
                            });
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
getSelectBien();

// Guardar nuevo Bien
$('#frm_nuevo_invent').on('submit', function(e) {
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
        url: "admin/storeBienInvent",
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


function mayus(e) {
        e.value = e.value.toUpperCase();
     };

// Mostrar modal para alta de rol


//$(".dt-buttons").addClass('kt-hidden');
