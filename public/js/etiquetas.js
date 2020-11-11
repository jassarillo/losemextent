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
            { data: 'factura', name: 'factura' },
            { data: 'precio', name: 'precio' },
            { data: 'conteo', name: 'conteo' },
            { data: 'progresivo', name: 'progresivo' },
            { data: 'unico', name: 'unico' },
            { data: 'conteo', name: 'conteo' },
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
    $(".optSeccion").remove();
    $.ajax({
        type: "GET",
        url :  "admin/listSeccion",
        dataType: "json",
        success: function (data)
                        {
                            //console.log(data[0]);
                            $(".selectpicker").selectpicker();
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#id_clasifica').append(
                                   '<option class="optSeccion" value="' + opt.id_seccion + '"> ' + opt.id_seccion +" "+ opt.descripcion +'</option> '
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


$('#id_clasifica').on('change', function(){
    //console.log("onchange selccion");
    getSelectBien();
});

$('#id_bien').on('change', function(){
    //console.log("onchange selccion");
    //getSelectBien();
    id_clasifica = $('#id_clasifica').val();
    id_bien = $('#id_bien').val();
    //console.log(id_clasifica);
    numRows(id_clasifica, id_bien, 0);
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
                                   '<option class="optInvent" value="' + opt.id + '"> ' + opt.id_clasificacion + "-" + opt.id + " - " + opt.descripcion + ' largo: '+ 
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
//getSelectBien();



    numRows = function(id_clasifica, id_bien, noInvent)
        {
            
            $(".otrasFilas").remove();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",        
                    dataType: "json",
                    url: "inventario/getNumRows",
                    data: {"id_clasifica": id_clasifica, "id_bien":id_bien, "noInvent":noInvent},
                    success: function (data)
                    {
                        console.log(data);
                        if(data.total == 0)
                        {
                            $("#messageRows").text("0 Registros a Imprimir.");
                        }
                        else
                        {
                            $("#messageRows").text("");
                             noInt =1;
                             console.log(data.last_page);
                             for(i =0; i < data.last_page; i++ )
                             {
                                rangeFin = noInt *20;
                                rangeIni = rangeFin - 20;
                                rangeIniPlus = parseInt(rangeIni) + 1;
                                $('#pages-table').append(
                                    '<tr class="otrasFilas">' +
                                        '<td>'+ noInt  +'</td> ' +
                                        '<td>'+ rangeIniPlus +' - ' + rangeFin +'</td> ' +
                                        //'<td> <a href="http://127.0.0.1:9000/imprimeEtiquetas/'+rangeIni+'/'+rangeFin+'/'+ id_bien +'" target="_blank" class="btn btn-success btn-group-lg active" ><i class="fas fa-print"></i></a> </td> ' +
                                        '<td> <a href="http://pdf.losemextent.com.mx/imprimeEtiquetas/'+rangeIni+'/'+rangeFin+'/'+ id_bien +'" target="_blank" class="btn btn-success btn-group-lg active" ><i class="fas fa-print"></i></a> </td> ' +
                                    '</tr>');
                                noInt++;
                            }
                         }


                        

                    },
                    error: function (data)
                    {
                            alert( data);
                    }
                })
        };


// Mostrar modal para alta de rol


//$(".dt-buttons").addClass('kt-hidden');
