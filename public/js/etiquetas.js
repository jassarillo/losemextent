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


/*$('#nro_progresivo').on('change', function(){
    
});*/

$('#id_bien').on('change', function(){
    //console.log("onchange selccion");
    //getSelectBien();
    id_clasifica = $('#id_clasifica').val();
    id_bien = $('#id_bien').val();
    indice_init = $('#indice_init').val();
    //console.log(id_clasifica);
    nro_progresivo =0;
    numRows(id_clasifica, id_bien, nro_progresivo, indice_init);
    getSelectNro(id_clasifica, id_bien);

});

$('#nro_progresivo').on('change', function(){
    id_clasifica = $('#id_clasifica').val();
    id_bien = $('#id_bien').val();
    nro_progresivo = $('#nro_progresivo').val();
    indice_init = $('#indice_init').val();


    numRows(id_clasifica, id_bien, nro_progresivo, indice_init);
    //getSelectNro(id_clasifica, id_bien);

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
                                 if(!opt.largo_medidaD){largo_medidaD ='';}else{largo_medidaD =opt.largo_medidaD; }
                                    if(!opt.ancho_medidaD){ancho_medidaD ='';}else{ancho_medidaD =opt.ancho_medidaD; }
                                    if(!opt.alto_medidaD){alto_medidaD ='';}else{alto_medidaD=opt.alto_medidaD;}
                                    if(!opt.diametro_medidaD){diametro_medidaD ='';}else{diametro_medidaD =opt.diametro_medidaD;}
                                    if(!opt.peso_medidaD){peso_medidaD ='';}else{peso_medidaD = opt.peso_medidaD;}
                                    if(!opt.volumen_medidaD){volumen_medidaD ='';}else{volumen_medidaD=opt.volumen_medidaD;}
                                    
                                    
                                    if(!opt.largo){largo ='0';}else{largo =opt.largo; }
                                    if(!opt.ancho){ancho ='0';}else{ancho =opt.ancho; }
                                    if(!opt.alto){alto ='0';}else{alto=opt.alto;}
                                    if(!opt.diametro){diametro ='0';}else{diametro =opt.diametro;}
                                    if(!opt.peso){peso ='0';}else{peso = opt.peso;}
                                    if(!opt.volumen){volumen ='0';}else{volumen=opt.volumen;}
                                    
                                    
                                    
                                 $('#id_bien').append(
                                  '<option class="optInvent" value="' + opt.id + '">' 
                                   + opt.id_clasificacion +"-"+ opt.id + " " + opt.descripcionB + ' largo: '+ largo+
                                   largo_medidaD+ '- ancho: ' +ancho + ancho_medidaD+'- alto: '+alto + alto_medidaD
                                   +'- diametro: '+diametro + diametro_medidaD +'- peso: ' +peso+ peso_medidaD+ '- volumen: '
                                   +volumen+ volumen_medidaD+'</option>'
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



    numRows = function(id_clasifica, id_bien, noInvent, indice_init)
        {
            
            $(".otrasFilas").remove();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",        
                    dataType: "json",
                    url: "inventario/getNumRows",
                    data: {"id_clasifica": id_clasifica, "id_bien":id_bien, 
                            "noInvent":noInvent},
                    success: function (data)
                    {
                        //console.log(data);
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
                                rangeFin = noInt * 30;
                                rangeIni = rangeFin - 30;
                                rangeIniPlus = parseInt(rangeIni) + 1;
                                $('#pages-table').append(
                                    '<tr class="otrasFilas">' +
                                        '<td>'+ noInt  +'</td> ' +
                                        '<td>'+ rangeIniPlus +' - ' + rangeFin +'</td> ' +
                                        //'<td> <a href="http://127.0.0.1:9000/imprimeEtiquetas/'+rangeIni+'/'+rangeFin+'/'+id_clasifica+'/'+ id_bien+'/'+ noInvent +'/'+ indice_init +'" target="_blank" class="btn btn-success btn-group-lg active" ><i class="fas fa-print"></i></a> </td> ' +
                                        '<td> <a href="http://pdf.losemextent.com.mx/imprimeEtiquetas/'+rangeIni+'/'+rangeFin+'/'+id_clasifica+'/'+ id_bien +'/'+noInvent+'/'+ indice_init +'" target="_blank" class="btn btn-success btn-group-lg active" ><i class="fas fa-print"></i></a> </td> ' +
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

        getSelectNro = function(id_clasifica, id_bien)
        {
            //console.log(id_clasifica,id_bien);
            $(".optNro").remove();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",        
                    dataType: "json",
                    url: "inventario/getNroId",
                    data: {"id_clasifica": id_clasifica, "id_bien":id_bien},
                    success: function (data)
                    {
                        //console.log(data);
                        
                        $.each(data, function (idx, opt) {
                            //console.log(opt.id);
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#nro_progresivo').append(
                                   '<option class="optNro" value="' + opt.id + '"> ' + opt.id + '</option> '
                                );
                               
                            });
                    },
                    error: function (data)
                    {
                            alert( data);
                    }
                })
        };


// Mostrar modal para alta de rol


//$(".dt-buttons").addClass('kt-hidden');
