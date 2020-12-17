$(document).ready(function() {
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
            { data: 'nomb1', name: 'nomb1' },
            { data: 'nomb2', name: 'nomb2' },
            { data: 'nomb3', name: 'nomb3' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'lugar', name: 'lugar' },
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
    getSelectInventario();
});

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
                                $('.selectpicker').selectpicker('refresh');
                            });
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
                                '<td>' + opt.id_evento + '</td>' +
                                '<td>'+opt.id_evento+' </td> ' +
                                '<td>'+opt.id_empleado+' </td> ' +
                            '</tr>');
                    });
                },

                error: function (data)
                { console.log(data);

                }
            });
};

$("#nro_empleado").change(function() {
            //contrato = $("#contrato").val();
            //console.log("frfrfrf");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "admin/insertEmpleado",
                data: {"idEvento": idEvento},
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
// Mostrar modal para alta de rol


//$(".dt-buttons").addClass('kt-hidden');
