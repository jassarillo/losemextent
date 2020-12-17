$(document).ready(function() {

    $('#nro_invent').on('change', function(){ // on change of state
        nro_invent = $("#nro_invent").val();
          $("#nro_invent").val('');
        console.log(nro_invent);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : url + "admin/get_datos_buscador/"+ nro_invent,
            type: "GET",
            dataType: 'html',
            success: function(data) {
                //console.log(data[0]['id']);
                var obj = jQuery.parseJSON( data );
                //getSelectCausaAlta_edit();

                getSelectCausaAlta_edit(obj[0]['causa_alta']);
                $("#id_update").val(obj[0]['id']);
                $("#descripcion_e").val(obj[0]['descripcion']);
                $("#fecha_alta_e").val(obj[0]['fecha_alta']);
                $("#estado_e").prop('selectedIndex', obj[0]['status_i']-1);
                $("#largo_e").val(obj[0]['largo']);
                $("#largo_e_medida").prop('selectedIndex', obj[0]['largo_medida']);
                $("#ancho_e").val(obj[0]['ancho']);
                $("#ancho_e_medida").prop('selectedIndex', obj[0]['ancho_medida']);
                $("#alto_e").val(obj[0]['alto']);
                $("#alto_e_medida").prop('selectedIndex', obj[0]['alto_medida']);
                $("#diametro_e").val(obj[0]['diametro']);
                $("#diametro_e_medida").prop('selectedIndex', obj[0]['diametro_medida']);
                $("#peso_e").val(obj[0]['peso']);
                $("#peso_e_medida").prop('selectedIndex', obj[0]['peso_medida']);
                $("#calibre_e").val(obj[0]['calibre']);
                $("#calibre_e_medida").prop('selectedIndex', obj[0]['calibre_medida']);
                $("#volumen_e").val(obj[0]['volumen']);
                $("#volumen_e_medida").prop('selectedIndex', obj[0]['volumen_medida']);

                //getSelectUso_edit(obj[0]['uso_material']);
                

                //$("#estado_e").val(obj[0]['estado']);

                //$("#causa_alta_e").prop('selectedIndex', 3);
                
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
            }
        });
    });

    function getSelectCausaAlta_edit(causa_alta) {
        //console.log(causa_alta);
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

    /*$('.existencias-table').each(function () {
        $(this).dataTable(window.dtDefaultOptions);
    });
    var dataTable = $('#existencias-table').dataTable({
        processing: true,
        serverSide: true,
        language: {
            "url": url + "assets/vendors/general/datatables/Spanish.json"
        },
        ajax: {
            "url": url + "admin/data_listar_existencias",
            "type": "GET"
        },
        columns: [
            {
                "mRender": function (data, type, row) {
                  
                    return  row.id ;
                }
            },
            { data: 'bodega', name: 'bodega' },
            { data: 'id_clasifica', name: 'id_clasifica' },
            { data: 'descSeccion', name: 'descSeccion' },
            { data: 'id_bien', name: 'id_bien' },
            { data: 'descBien', name: 'descBien' },
            { data: 'conteo_existencia', name: 'conteo_existencia' },
            { data: 'created_at', name: 'created_at' },
          
            

        ]
        });*/


});





// Mostrar modal para alta de rol


//$(".dt-buttons").addClass('kt-hidden');
