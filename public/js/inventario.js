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
            {
                "mRender": function (data, type, row) {
                  
                    return  row.id_clasifica + '' + row.id_bien + '' + row.progresivo;
                }
            },
            { data: 'descClasif', name: 'descClasif' },
            { data: 'descBien', name: 'descBien' },
            { data: 'factura', name: 'factura' },
            { data: 'precio', name: 'precio' },
            { data: 'conteo', name: 'conteo' },
            { data: 'progresivo', name: 'progresivo' },
            { data: 'unico', name: 'unico' },
            { data: 'conteo', name: 'conteo' },
            {
                "mRender": function (data, type, row) {
                    var id_user = row.id;
                    //return '<a class="btn btn-cdmx" onClick="get_data_edit_inventario('+id_user+');" href="javascript:void(0)">Editar</a>';
                    return '<a onclick="get_data_edit_inventario('+ row.id +');" href="#'+row.id+'" class="btn btn-cdmx" data-toggle="modal" data-target="#kt_modal_KTDatatable_local" >Editar</a>';

                }
            }

        ]
        });
});

function getSelectSeccion() {
    $(".optSeccion").remove();
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
                                   '<option class="optSeccion" value="' + opt.id_seccion + '"> ' + opt.id_seccion +" "+ opt.descripcion +'</option> '
                                );
                            });
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
getSelectSeccion();


$('#id_clasifica').on('change', function(){
    console.log("onchange selccion");
    getSelectBien();
});


function getSelectBien() {

    val_clasif = $("#id_clasifica").val();
    //if(val_clasif == 0){ 
        //console.log(val_clasif);
    //}

    $(".optInvent").remove();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url :  "admin/listBienes",
        data: {"val_clasif":  val_clasif},
        dataType: "json",
        success: function (data)
                        {
                            $(".selectpicker").selectpicker();
                            //console.log(data[0]);
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#id_bien').append(
                                   '<option class="optInvent" value="' + opt.id + '"> ' + opt.id_clasificacion +"-"+ opt.id + " " + opt.descripcion + ' largo: '+ 
                                   opt.largo+'</option> '
                                );
                                $('.selectpicker').selectpicker('refresh');
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
        url: "admin/storeMasivo",
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

function get_data_edit_inventario(id_bien) {
    //console.log(id_bien);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/get_data_edit_inventario/"+ id_bien,
        dataType: 'html',
        success: function(data) {
            //console.log(data);
            var obj = jQuery.parseJSON( data );

            console.log(obj);
            $("#fecha_inventario_e").val(obj[0]['fecha_inventario']);
            //getSelectCausaAlta_edit();

            /*getSelectCausaAlta_edit(obj[0]['causa_alta']);
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
            */

            //$("#estado_e").val(obj[0]['estado']);

            //$("#causa_alta_e").prop('selectedIndex', 3);
            
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}


$("#conteo").keyup(function() {
            //console.log( "r34D!" );

            nroBienes = $("#conteo").val();
            id_bien = $("#id_bien").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "admin/extractProgresivoMaxMin",
                data: {"id_bien": id_bien,"nroBienes":nroBienes},
                success: function( data ) {
                    //console.log(data);
                      console.log(data[0]['numero']);
                      numero = data[0]['numero'];
                      numeroFin = parseInt(numero) + parseInt(nroBienes);
                        $("#ini").val(numero);
                        $("#fin").val(numeroFin - 1);

                        $("#preinsert").addClass('btn-success-2', true);
                        $("#preinsert").prop('disabled', false);
                },

                error: function (data)
                { console.log(data);

                }
            })

});

$('#unico').on('change', function(){ // on change of state
           if(this.checked) // if changed state is "CHECKED"
            {
                console.log("chido!");
                $("#hideUnico").hide();
                //$("#partidaCatalogo").show();
            }
            else
            {
                $("#hideUnico").show();
            }
});

function mayus(e) {
        e.value = e.value.toUpperCase();
     };

// Mostrar modal para alta de rol


//$(".dt-buttons").addClass('kt-hidden');
