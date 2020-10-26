$(document).ready(function() {
    $('.existencias-table').each(function () {
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
        });
});





// Mostrar modal para alta de rol


//$(".dt-buttons").addClass('kt-hidden');
