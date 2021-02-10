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
                    //return '<a onclick="ver_acuse_pdf('+ row.id +');" href="#'+row.id+'" class="btn btn-default"  data-toggle="modal" data-target="#kt_modal_imagen_local" ><i class="fa fa-print" aria-hidden="true"></i>Imprimir</a>';
                    return '<a  href="http://pdf.losemextent.com.mx/acuseEvento/'+row.id+'" target="_blank" class="btn btn-default"  ><i class="fa fa-print" aria-hidden="true"></i>Imprimir</a>';
                    
                }
            },
            {
                "mRender": function (data, type, row) {
                    
                   // return '<a class="btn btn-cdmx" onClick="edit_user_modal('+id_user+');" href="javascript:void(0)">Editar</a>';
                    return '<a onclick="get_data_edit_evento('+ row.id +');" href="#'+row.id+'" class="btn btn-cdmx" data-toggle="modal" data-target="#kt_modal_KTDatatable_local" >Editar</a>';

                }
            },
            {
                "mRender": function (data, type, row) {
                    
                    return '<a class="btn btn-danger" onClick="eliminar_evento(' + row.id + ');" href="javascript:void('+ row.id +')">Eliminar</a>';
                   
                }
            }
        ]
        });
    function selectBienesAEventoSalida() 
    {
        filtro=0;
               
                data_table_salida = $("#bienes-evento-salida-table").DataTable({
                   
                    "buttons": [
                        'csv', 'excel', 'pdf', 'print'
                    ],
                    "ajax": {
                        "url":   "admin/listar_bienes_evento_salida",
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
                        { data: 'idOrigin', name: 'idOrigin' },
                        { data: 'descClasif', name: 'descClasif' },
                        { data: 'descBien', name: 'descBien' },

                        {
                            "mRender": function (data, type, row) {
                                if(row.unico == 1)
                                {
                                    cant = row.conteo
                                }
                                else
                                {
                                    cant = 1
                                }
                                return cant;
                            }
                        },
                        {
                            "mRender": function (data, type, row) {
                                //var id_user = row.idInvent;
                                if(row.status == '1')
                                {
                                return '<a class="btn btn-danger" onClick="eliminar_bien_evento(' + row.idInvent +','
                                + row.id_clasifica + ',' +row.id_bien +','+row.unico+','+row.conteo+');" href="javascript:void('+ row.idInvent+')">Eliminar</a>';
                                }
                                else
                                { //console.log(5444444);
                                    return '';
                                }
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
    selectBienesAEventoSalida();

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
                        { data: 'idOrigin', name: 'idOrigin' },
                        { data: 'descClasif', name: 'descClasif' },
                        { data: 'descBien', name: 'descBien' },
                        { data: 'observaciones', name: 'observaiones' },
                        { data: 'updated_at', name: 'updated_at' },
                        //{ data: 'estado_fisico', name: 'estado_fisico' },
                        {
                            "mRender": function (data, type, row) {
                                if(row.estado_fisico == 1){
                                    estado = "Bueno"; }
                                else if(row.estado_fisico == 2){
                                    estado = "Regular";
                                }else if(row.estado_fisico == 3){
                                    estado = "Malo";
                                }else{
                                    estado ="Bueno";
                                }
                                return estado;
                            }
                        },
                        {
                            "mRender": function (data, type, row) {
                                if(row.unico == 1)
                                {
                                    cant = row.conteo
                                }
                                else
                                {
                                    cant = 1
                                }
                                return cant;
                            }
                        },
                        {
                            "mRender": function (data, type, row) {
                                //var id_user = row.idInvent;
                                if(row.status == '1')
                                {
                                return '<a class="btn btn-primary" onClick="remover_bien_evento(' + row.idOrigin +','
                                + row.id_clasifica + ',' +row.id_bien +','+row.unico+','+row.conteo+');" href="javascript:void('+ row.idOrigin+')">Entrada</a>';
                                }
                                else
                                { //console.log(5444444);
                                    return '';
                                }
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

    $('#evento_e').on('change', function () {
                    
                    reloadDataTableEventSend();

        });

        function reloadDataTableInvent(){
            evento_id=$("#evento").val();
            //console.log(evento_id);
                    eligeBien=$("#eligeBien").val();
                    //console.log(eligeSeccion);
                    data_table.ajax.url("admin/listar_bienes_evento?inicio=" +1
                        +"&evento_id=" + evento_id ).load();
        }; 

        function reloadDataTableEventSend(){
            evento_id=$("#evento_e").val();
            //console.log(evento_id);
                    eligeBien=$("#eligeBien").val();
                    //console.log(eligeSeccion);
                    data_table_salida.ajax.url("admin/listar_bienes_evento_salida?inicio=" +1
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
                //Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success",{timer: 2000});
                Swal.fire({
                          position: 'top-end',
                          icon: 'success',
                          title: 'Elemento añadido',
                          showConfirmButton: false,
                          timer: 1500
                        })
                getSelectInventario();
                reloadDataTableEventSend();
                getCantidad();
                $('#boxNumberInput').val('');
                $('#codigoInvent').val('');
                dd = $("#unico").val();
                if(dd=="on")
                {
                    $("#boxNumber").hide();
                }                    
               
               }
                    
                   //$('#eventos-table').DataTable().ajax.reload();

            } else {
                $("#boxNumber").show();
                getCantidad();
                Swal.fire("Es necesario indicar Cantidad!", "Elemento con una etiqueta!","warning");
            }
            
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');

        }
    });
});


        // Retorno bien de un evento
$('#frm_retorno_de_evento').on('submit', function(e) {
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
        url: "admin/itemReturnEvent",
        data: formData, 
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            //console.log(respuesta.resp);
            
            if (respuesta.resp == true) 
            {
                //console.log(666);
               if(respuesta.mensaje == 'Elemento no disponible')
               {

                Swal.fire("Elemento no disponible!", "Verificar existencia!","warning");
                
               }
               else
               {
                Swal.fire({
                          position: 'top-end',
                          icon: 'success',
                          title: 'Entrada correcta!',
                          showConfirmButton: false,
                          timer: 1500
                        })
                
                reloadDataTableInvent();
                
                $('#boxNumberInput').val('');
                $('#codigoInvent').val('');
               }
                    
                   //$('#eventos-table').DataTable().ajax.reload();

            }else{

                $("#boxNumber").show();
                getCantidadEnEvento();
                Swal.fire("Es necesario indicar Cantidad!", "Elemento con una etiqueta!","warning");
            }
            
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');

        }
    });
});


eliminar_bien_evento = function (idInvent,id_clasifica,id_bien,unico,conteo){
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

eliminar_evento = function (id_evento){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/eliminar_evento/"+ id_evento,
        dataType: 'html',
        success: function(respuesta) {
                    var obj = jQuery.parseJSON( respuesta );
                    //console.log(obj.resp);
                    if(obj.resp == true) {
                        //console.log(666);
                       $('#eventos-table').DataTable().ajax.reload();
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


remover_bien_evento = function (idInvent,id_clasifica,id_bien,unico,conteo) {
    console.log(idInvent);
    inputRestar =1;
    evento=$("#evento").val();
    observaciones=$("#observaciones").val();
    estado_fisico=$("#estado_fisico").val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        //url : url + "admin/remover_bien_evento/"+evento+"/"+id_clasifica+"/"+id_bien+"/"+unico+"/"+conteo+"/"+idInvent+"/"+inputRestar+"/"+observaciones+"/"+estado_fisico,
        url : url + "admin/remover_bien_evento/"+evento+"/"+id_clasifica+"/"+id_bien+"/"+unico+"/"+conteo+"/"+idInvent+"/"+inputRestar+"/"+observaciones+"/"+estado_fisico,
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
            $("#remision_e").val(obj[0]['remision']);
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
                            $(".selectpicker").selectpicker();
                            $.each(data, function (idx, opt) {
                                  // alert('Estoy recorriendo el registro numero: ' + idx);
                                  //console.log(opt);
                                $('#id_clasifica').append(
                                   '<option class="optSeccion" value="' + opt.id_seccion + '"> ' + opt.id_seccion +" "+ opt.descripcion +'</option> '
                                );
                            });
                            $('.selectpicker').selectpicker('refresh');

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
                                  '<option class="optBien" value="' + opt.id + '">' 
                                   + opt.id_clasificacion +"-"+ opt.id + " " + opt.descripcionB + ' largo: '+ largo+
                                   largo_medidaD+ '- ancho: ' +ancho + ancho_medidaD+'- alto: '+alto + alto_medidaD
                                   +'- diametro: '+diametro + diametro_medidaD +'- peso: ' +peso+ peso_medidaD+ '- volumen: '
                                   +volumen+ volumen_medidaD+'</option>'
                                );
                                
                            });
                            $('.selectpicker').selectpicker('refresh');
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
    val_clasif = $("#id_clasifica").val();
    id_bien = $("#id_bien").val();
    codigoInvent = $("#codigoInvent").val();
    $(".optInvent").remove();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url :  "admin/cantidadExistente",
        data: {"val_clasif":  val_clasif, "id_bien": id_bien,"codigoInvent":codigoInvent},
        dataType: "json",
        success: function (data)
                        {
                            //console.log(data);
                            if(data !='')
                            {
                            $("#inputRestar").val(data[0].conteo_a);
                            $("#idInventUnico").val(data[0].idInvent);
                            $("#inputRestar").prop('disabled', true);
                            }

                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}

function getCantidadEnEvento() {
    evento = $("#evento").val();
    codigoInvent = $("#codigoInvent").val();
    //$(".optInvent").remove();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url :  "admin/cantidadEnEvento",
        data: {"codigoInvent":  codigoInvent,"evento":evento},
        dataType: "json",
        success: function (data)
                        {
                            if(data == '')
                            {
                                //console.log("ededed");
                                $("#boxNumber").hide();
                                Swal.fire('¡Alerta!','Elemento ya verifcado','warning');

                            }
                            else
                            {
                                $("#inputRestar").val(data[0].conteo_a);
                                $("#idInventUnico").val(data[0].idInvent);
                                //$("#inputRestar").prop('disabled', true);
                            }
                            

                            

                        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
        }
    });
}

$('#boxNumberInput').on('keyup', function(){ // on change of state
    boxNumberInput = $("#boxNumberInput").val();
    inputRestar = $("#inputRestar").val();
    console.log(boxNumberInput);
    if(boxNumberInput > inputRestar)
    {
        alert("La cantidad es mayor a la existente");
    }
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
                                   '<option class="optInvent" value="' + opt.id + '"> ' + opt.id +" "+ opt.descripcion +'</option> '
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
    $("#remision").val("");
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
                $("#boxNumber").hide();
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

                                $('#evento_e').append(
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
                                '<td>'+opt.nro_empleado+' </td> ' +
                                '<td>'+opt.nombre_completo+' </td> ' +
                                '<td>'+
                                    //'<a onclick="deleteEmpleado('+ opt.nro_empleado +');" href="#'+opt.nro_empleado+'" class="btn btn-danger" >Eliminar</a>'+
                                    //'<a onclick="get_data_edit_evento('+ opt.nro_empleado +');" href="#'+opt.nro_empleado+'" class="btn btn-danger"  data-target="#kt_modal_KTDatatable_local" >Elii</a>'+
                                    '<a class="btn btn-danger" onClick="deleteEmpleado(' + opt.nro_empleado +',2);" href="javascript:void('+ opt.nro_empleado+')">Eliminar</a>'+
                                '</td> '+
                            '</tr>');
                    });
                },

                error: function (data)
                { console.log(data);

                }
            });
};

//remover_bien_evento = function (idInvent,id_clasifica,id_bien,unico,conteo) {

function deleteEmpleado(id_empleado,tipoEmpleado) {
    
    teamEvento = $("#teamEvento").val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : url + "admin/deleteEmpleado",
        type: 'POST',
        data: {'id_empleado':id_empleado, 'tipoEmpleado': tipoEmpleado, "teamEvento":teamEvento},
        dataType: 'json',
        success: function(response) {
                getTeamList(teamEvento);
                getResponsableList(teamEvento);
                //reloadDataTableInvent();
                Swal.fire('¡Correcto!',response.message,'success');
                //$('#users-table').DataTable().ajax.reload();
               
           
        },
        error: function(xhr) {
         //   var message = getErrorAjax(xhr, 'Error de conectividad de red USR-02.');
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
};

function getResponsableList(idEvento) {
      $(".otrosTeam").remove();
           $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "admin/getListResponsable",
                data: {"idEvento": idEvento},
                success: function( data ) {

                   //Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success");
                     $.each(data, function (idx, opt) {
                        $('#responsableTable').append(
                            '<tr class="otrosTeam">' +
                                '<td>' + opt.id_event + '</td>' +
                                '<td>'+opt.destino+' </td> ' +
                                '<td>'+opt.nro_empleado+' </td> ' +
                                '<td>'+opt.nombre_completo+' </td> ' +
                                '<td>'+
                                    '<a class="btn btn-danger" onClick="deleteEmpleado(' + opt.nro_empleado +',1);" href="javascript:void('+ opt.nro_empleado+')">Eliminar</a>'+
                                '</td>'+
                            '</tr>');
                    });
                },

                error: function (data)
                { console.log(data);

                }
            });
};

$("#nro_empleado").change(function() {
    insertar_empleado();
});

$("#nro_empleado_responsable").change(function() {
    insertar_empleado();
});

//555555
function insertar_empleado(){
        nro_empleado_responsable = $("#nro_empleado_responsable").val();
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
                data: {"nro_empleado": nro_empleado, "teamEvento":teamEvento, 
                "nro_empleado_responsable":nro_empleado_responsable},
                success: function( data ) {
                   Swal.fire("Proceso  correcto!", "Bien registrado correctamente!","success");
                   idEvento = $("#teamEvento").val();
                   $("#nro_empleado").val('');
                   $("#nro_empleado_responsable").val('');
                   getTeamList(idEvento);
                   getResponsableList(idEvento);
                },

                error: function (data)
                { console.log(data);

                }
            });
    }


//555555


$("#teamEvento").change(function() {
            idEvento = $("#teamEvento").val();
            getTeamList(idEvento);
            getResponsableList(idEvento);
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

