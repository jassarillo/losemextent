$(document).ready(function() {


    function dashboardHeader() {
        $(".optSeccionSearch").remove();
        $.ajax({
            type: "GET",
            url :  "admin/getTotalNumbers",
            dataType: "json",
            success: function (data)
                            {
                                /*0: {countSecciones: 114}
                                1: {countBienes: 103}
                                2: {countInvent: 195}
                                3: {countEventos: 5}
                                4: {countEmpleados: 4}
                                */
                                //console.log(data[0]['countSecciones']);
                                $("#idSecciones").text(data[0]['countSecciones']);
                                $("#idBienes").text(data[1]['countBienes']);
                                $("#idInventario").text(data[2]['countInvent']);
                                $("#idEventos").text(data[3]['countEventos']);
                                $("#idEmpleados").text(data[4]['countEmpleados']);

                                    
                            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
            }
        });
    }
    
    dashboardHeader();


    function InventDisponibles() {
        $(".otrosTeam").remove();
        $.ajax({
            type: "GET",
            url :  "admin/InventDisponibles",
            dataType: "json",
            success: function (data)
                            {
                                
                                //console.log(data);
                                i=1;
                                //cantidad='';
                                $.each(data, function (idx, opt) {
                                //cantidad ='<span class="btn btn-label-success btn-sm btn-bold btn-upper">'+ opt.conteo +'</span>';

                                $('#disponibles').append(
                                    '<tr class="otrosTeam">' +
                                        '<td>' + i + '</td>' +
  
                                        '<td>'+opt.descClasif+' </td> ' +
                                        '<td>'+ opt.conteo +' </td> ' +
                                    '</tr>');
                                i++;
                                });

                                    
                            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
            }
        });
    }
    
    InventDisponibles();

    function bienesEnUso() {
        $(".otrosTeam").remove();
        $.ajax({
            type: "GET",
            url :  "admin/bienesEnUso",
            dataType: "json",
            success: function (data)
                            {
                                
                                //console.log(data);
                                i=1;
                                //cantidad='';
                                $.each(data, function (idx, opt) {
                                //cantidad ='<span class="btn btn-label-success btn-sm btn-bold btn-upper">'+ opt.conteo +'</span>';

                                $('#enUso-table').append(
                                    '<tr class="otrosTeam">' +
                                        '<td>' + i + '</td>' +
            
                                        '<td>'+opt.descClasif+' </td> ' +
                                        '<td>'+ opt.conteo +' </td> ' +
                                    '</tr>');
                                i++;
                                });

                                    
                            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-01','warning');
            }
        });
    }
    
    bienesEnUso();
});






