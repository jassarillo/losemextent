$(document).ready(function() {
    $("#boxNumber").hide();

    $('.inventarios-table').each(function () {
        $(this).dataTable(window.dtDefaultOptions);
    });
    var dataTable = $('#eventos-table').dataTable({
        processing: true,
        serverSide: true,
        language: {
            "url": url + "assets/vendors/general/datatables/Spanish.json"
        },
        ajax: {
            "url": url + "admin/data_listar_eventos",
            "type": "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'destino', name: 'destino' },
            { data: 'fecha', name: 'fecha' },
            { data: 'hora', name: 'hora' },
//           { data: 'nomb1', name: 'nomb1' },
//            { data: 'nomb2', name: 'nomb2' },
//            { data: 'nomb3', name: 'nomb3' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'lugar', name: 'lugar' },
            {
                "mRender": function (data, type, row) {
                    var id_user = row.id;
                    //return '<a class="btn btn-primary" onClick="edit_user_modal('+id_user+');" href="javascript:void(0)">Editar</a>'; ----glyphicon glyphicon-print
                    return '<a onclick="ver_acuse_pdf('+ row.id +');" href="#'+row.id+'" class="btn btn-default"  data-toggle="modal" data-target="#kt_modal_imagen_local" ><i class="fa fa-print" aria-hidden="true"></i>Imprimir</a>';
                    
                }
            },
            {
                "mRender": function (data, type, row) {
                    
                   // return '<a class="btn btn-cdmx" onClick="edit_user_modal('+id_user+');" href="javascript:void(0)">Editar</a>';
                    return '<a onclick="get_data_edit_evento('+ row.id +');" href="#'+row.id+'" class="btn btn-cdmx" data-toggle="modal" data-target="#kt_modal_KTDatatable_local" >Editar</a>';

                }
            }
        ]
        });

    function selectBienesAEvento() 
    {
        filtro=0;
               
                data_table = $("#bienes-evento-table").DataTable({
                   
                    "buttons": [
                        'csv', 'excel', 'pdf', 'print'
                    ],
                    "ajax": {
                        "url":   "admin/listar_bienes_evento",
                        "data": { filtro: filtro },//Consulta a PAGOSUNIFICADOS
                        "type": "GET",
                        "datatype": "json"
                    },
                    "columnDefs":
                        [{
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }],

                    "columns": [
                        { data: 'unico', name: 'unico' },
                        { data: 'idInvent', name: 'idInvent' },
                        { data: 'descClasif', name: 'descClasif' },
                        { data: 'descBien', name: 'descBien' },
                        { data: 'factura', name: 'factura' },
                        {
                            "mRender": function (data, type, row) {
                                //var id_user = row.idInvent;
                                return '<a class="btn btn-danger" onClick="remover_bien_evento(' + row.idInvent +','
                                + row.id_clasifica + ',' +row.id_bien +');" href="javascript:void('+ row.idInvent+')">Eliminar</a>';
                                //    return '<a onclick="remover_bien_evento('+ row.idInvent +');" href="#'+row.idInvent+'" class="btn btn-danger" >Eliminar</a>';
                            }
                        }
                       
                    ],
                    "drawCallback": function () {
                        $(".creditos").change(function () {
                            if ($(this).is(':checked')) {
                                //console.log($(this).val());
                                if ($.inArray($(this).val(), creditos) == -1) {
                                    //creditos[] = $(this).val();
                                    creditos.push($(this).val());
                                }

                            }
                            else {
                                //creditos.pop($(this).val())
                                creditos.splice($.inArray($(this).val(), creditos), 1);
                            }
                            console.log(creditos);
                        });

                    }
                });
    };
    selectBienesAEvento();   

    $('#evento').on('change', function () {
                    
                    reloadDataTableInvent();

        });

        function reloadDataTableInvent(){
            evento_id=$("#evento").val();
            //console.log(evento_id);
                    eligeBien=$("#eligeBien").val();
                    //console.log(eligeSeccion);
                    data_table.ajax.url("admin/listar_bienes_evento?inicio=" +1
                        +"&evento_id=" + evento_id ).load();
        }; 


        // Salida nuevo Bien a evento
$('#frm_salida_a_evento').on('submit', function(e) {
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
            
            if (respuesta.resp == true) {
                //console.log(666);
               if(respuesta.mensaje == 'Elemento no disponible')
               {

                Swal.fire("Elemento no disponible!", "Verificar existencia!","warning");
                
               }
               else
               {
                Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success");
                getSelectInventario();
                reloadDataTableInvent();
               }
                    
                   //$('#eventos-table').DataTable().ajax.reload();

            } else {
                Swal.fire('error', respuesta.message,"error");
            }
            $('#codigoInvent').val('');
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');

        }
    });
});

remover_bien_evento = function (idInvent,id_clasifica,id_bien) {
    //console.log(id_event);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/remover_bien_evento/"+ idInvent+"/"+id_clasifica+"/"+id_bien,
        dataType: 'html',
        success: function(respuesta) {
                    var obj = jQuery.parseJSON( respuesta );
                    //console.log(obj.resp);
                    if(obj.resp == true) {
                        //console.log(666);
                       reloadDataTableInvent();
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

function get_data_edit_evento(id_event) {
    //console.log(id_event);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/get_data_edit_evento/"+ id_event,
        dataType: 'html',
        success: function(data) {
            console.log(data);
            var obj = jQuery.parseJSON( data );
            //getSelectCausaAlta_edit();
            
            $("#destino_e").val(obj[0]['destino']);
            $("#fecha_e").val(obj[0]['fecha']);
            $("#hora_e").val(obj[0]['hora']);
            $("#descripcion_e").val(obj[0]['descripcion']);
            $("#lugar_e").val(obj[0]['lugar']);
            $("#id_update").val(obj[0]['id']);

            
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
};





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
    //console.log("onchange selccion");
    getSelectBien();
});


function getSelectBien() {

    val_clasif = $("#id_clasifica").val();
    //if(val_clasif == 0){ 
        //console.log(val_clasif);
    //}

    $(".optBien").remove();
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
$('#id_bien').on('change', function(){
    //console.log("onchange selccion");
    val_clasif = $("#id_clasifica").val();
    id_bien = $("#id_bien").val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url :  "admin/unicoMuchos",
        data: {"val_clasif":  val_clasif, "id_bien": id_bien},
        dataType: "json",
        success: function (data)
                        {   //console.log(data[0].unico);
                            if(data[0].unico == 1)
                            {
                                $("#boxNumber").show();
                                $("#inventariadoOnOff").hide();
                                getCantidad();
                            }
                            else if(data[0].unico == 0)
                            {
                                $("#boxNumber").hide();
                                $("#inventariadoOnOff").show();
                                //$("#boxNumber").show();
                                //$("#codigo_input").hide();

                                getSelectInventario();
                            }

                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });


});

function getCantidad() {
    //////////////////////////////////////////
    //////////////////////////////////////////
    //////////////////////////////////////////
    val_clasif = $("#id_clasifica").val();
    id_bien = $("#id_bien").val();

    

    $(".optInvent").remove();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url :  "admin/cantidadExistente",
        data: {"val_clasif":  val_clasif, "id_bien": id_bien},
        dataType: "json",
        success: function (data)
                        {
                            //console.log(data);
                            $("#inputRestar").val(data[0].conteo_a);
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}

function getSelectInventario() {

    val_clasif = $("#id_clasifica").val();
    id_bien = $("#id_bien").val();

    //if(val_clasif == 0){ 
        //console.log(val_clasif);
    //}

    $(".optInvent").remove();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url :  "admin/listInventario",
        data: {"val_clasif":  val_clasif, "id_bien": id_bien},
        dataType: "json",
        success: function (data)
                        {
                            $(".selectpicker").selectpicker();
                            //console.log(data[0]);
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#id_inventario').append(
                                   '<option class="optInvent" value="' + opt.id + '"> ' + opt.id_clasifica+ opt.id_bien+ opt.progresivo +" "+ opt.descripcion +'</option> '
                                );
                                
                            });
                            $('.selectpicker').selectpicker('refresh');
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
//getSelectInventario();


// Guardar un Evento
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
        url: "admin/storeEventos",
        data: formData, 
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            //console.log(respuesta.resp);
            
            if (respuesta.resp == true) {
                //console.log(666);
                getSelecEvento();
                Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success");
                getSelectInventario();
               
                    limpiarFormEvento();
                   $('#eventos-table').DataTable().ajax.reload();

            } else {
                Swal.fire('error', respuesta.message,"error");
            }
            $('#codigoInvent').val('');
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');

        }
    });
});


function limpiarFormEvento() {
    $("#destino").val("");
    $("#fecha").val("");
    $("#hora").val("");
    $("#descripcion").val("");
    $("#lugar").val("");
    $("#empleado1").val("");
    $("#empleado2").val("");
    $("#empleado3").val(""); 
};





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
            });

});
$("#codigo_input").hide();
$('#unico').on('change', function(){ // on change of state
           if(this.checked) // if changed state is "CHECKED"
            {
                console.log("chido!");
                $("#hideUnico").hide();
                $("#codigo_input").show();
                //$("#id_clasifica").val();
                //$("#id_bien").val();
            }
            else
            {
                $("#hideUnico").show();
                $("#codigo_input").hide();

            }
});

function mayus(e) {
        e.value = e.value.toUpperCase();
     };

function getSelecEvento() {

    val_clasif = $("#id_clasifica").val();
    //if(val_clasif == 0){ 
        //console.log(val_clasif);
    //}

    $(".optEvent").remove();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url :  "admin/listEventos",
        data: {"val_clasif":  val_clasif},
        dataType: "json",
        success: function (data)
                        {
                            $(".selectpicker").selectpicker();
                            //console.log(data[0]);
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#evento').append(
                                   '<option class="optEvent" value="' + opt.id + '"> ' 
                                   + opt.id +" "+ opt.destino +'</option> '
                                );

                                $('#teamEvento').append(
                                   '<option class="optEvent" value="' + opt.id + '"> ' 
                                   + opt.id +" "+ opt.destino +'</option> '
                                );
                                $('.selectpicker').selectpicker('refresh');
                            });
                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}
getSelecEvento();


$('#teamEvento').on('blur', function(){ // on change of state
    idEvento = $("#teamEvento").val();
    getTeamList(idEvento);
});

function getTeamList(idEvento) {
      $(".otrosTeam").remove();
           $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "admin/getListTeam",
                data: {"idEvento": idEvento},
                success: function( data ) {

                   //Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success");
                     $.each(data, function (idx, opt) {
                        $('#teamTable').append(
                            '<tr class="otrosTeam">' +
                                '<td>' + opt.id_event + '</td>' +
                                '<td>'+opt.destino+' </td> ' +
                                '<td>'+opt.nombre_completo+' </td> ' +
                            '</tr>');
                    });
                },

                error: function (data)
                { console.log(data);

                }
            });
};

$("#nro_empleado").change(function() {
            nro_empleado = $("#nro_empleado").val();
            teamEvento = $("#teamEvento").val();
            //contrato = $("#contrato").val();
            //console.log("frfrfrf");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "admin/insertEmpleado",
                data: {"nro_empleado": nro_empleado, "teamEvento":teamEvento},
                success: function( data ) {
                   Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success");
                   idEvento = $("#teamEvento").val();
                   //$("#nro_empleado").val();
                   getTeamList(idEvento);
                },

                error: function (data)
                { console.log(data);

                }
            });

});



$("#teamEvento").change(function() {
            idEvento = $("#teamEvento").val();
            getTeamList(idEvento)
});

$('#frm_edit_evento').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('_token', $('input[name=_token]').val());
    //console.log(formData);
    
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //url : url + "admin/storeBien",
                type: "POST",
                dataType: "json",
                url: "admin/updateEvento",
                data: formData, 
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta) {
                    //console.log(respuesta.resp);
                    if (respuesta.resp == true) {
                        //console.log(666);
                       
                            Swal.fire("Proceso  correcto!", "Registro exitoso!","success");
                           $('#eventos-table').DataTable().ajax.reload();
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

function ver_acuse_pdf(idBien){
    //console.log(yearCut);
    //$('#img_modal').attr('src', 'http://localhost:9000/acuseEvento/27');//'uploads/inventarios_img/'+yearCut+'/'+idBien+'.jpg');
    $('#img_modal').attr('src', 'http://pdf.losemextent.com.mx/acuseEvento/'+idBien);//'uploads/inventarios_img/'+yearCut+'/'+idBien+'.jpg');
}

