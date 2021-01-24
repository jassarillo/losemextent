<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//$variable = 
Auth::routes();
//dd($variable);
    $sesDep = Session::get('idUserSes');
    //dd($sesDep);

Route::resource('roles', 'RoleController');

Route::get('/error/{error}', 'ErrorController@error');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/register/verify/{code}', 'Auth\LoginController@verify');
Route::post('/register', 'Auth\RegisterController@create')->name('create');
Route::post('/passReset', 'Auth\ResetPasswordController@resetPassword');
Route::get('/validator/{id}', 'Auth\RegisterController@validator')->name('validator');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/contactos', 'HomeController@contactoIndex')->name('home');
Route::get('/condTerminos', 'HomeController@condTerminos')->name('condTerminos');
Route::get('/contactos', 'HomeController@contactos')->name('contactos');
Route::post('/passReset', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('/passForgot', 'Auth\ForgotPasswordController@validateEmail')->name('passReset');
Route::post('/passUpdate', 'Auth\ForgotPasswordController@updatePass')->name('updatePass');
Route::get('/forgot/verify/{id}', 'Auth\ForgotPasswordController@validateTokenPassReset')->name('forgotPassW');

//Route::get('/login', 'Auth\LoginController@login');


Route::get('/', function () {
    //dd();
    if (Auth::check()){
        //dd(3333);
            return redirect('/admin');
    }else{
        //dd(777);
        return redirect('/login');
    }
});

if (Auth::check()){ 
    //dd(33);
    Route::get('/login', function () 
    {
        if (Auth::check())
        { //dd(44);
            return redirect('/admin');
        }
        else
        { //dd(55);
            Route::get('/login', 'Auth\LoginController@login');   
        }

    });
}


//Rutas con AUTH, todas las rutas deben de pasar por auth como validación
Route::group(['middleware' => ['auth']], function() {
    //Inicia Middleware de rol
    Route::group(['middleware' => ['role:SuperAdmin|admin']], function() {
    //editar usuarios
        Route::group(['prefix' => 'admin'], function() {
        Route::get('/', 'AdminController@dashboard');
        Route::get('/index', 'AdminController@index');
        Route::get('/listar_usuarios', 'AdminController@listar_usuarios');
        Route::get('/data_resumen_proveedores', 'AdminController@data_resumen_proveedores');
        Route::get('/data_listar_usuarios', 'AdminController@data_listar_usuarios');
        Route::get('/data_listar_roles', 'AdminController@data_listar_roles');
        Route::get('/data_licitaciones', 'AdminController@data_licitaciones');
        Route::get('/create', 'AdminController@create');
        Route::get('/edit', 'AdminController@edit');
        Route::post('/store', 'AdminController@store');
        Route::post('/update', 'AdminController@update');
        //Rutas Permisos
        Route::get('/listar_permisos', 'AdminController@listar_permisos');
        Route::get('/create_permiso', 'AdminController@create_permiso');
        Route::post('/store_new_permiso', 'AdminController@store_new_permiso');
        Route::get('/permiso/{id}/editar_permiso_modal', 'PermissionController@editar_permiso_modal');
        Route::post('/permiso/editar_permiso', 'PermissionController@update');
        
        //Rutas Role
        Route::get('/listar_roles', 'AdminController@listar_roles');
        Route::get('/roles/{id}/editar_roles_permisos', 'RoleController@editar_roles_permisos');
        Route::get('/create_rol', 'AdminController@create_rol');
        Route::post('/store_new_role', 'AdminController@store_new_role');
        });
    });
Route::get('admin', 'AdminController@dashboard');
Route::get('admin/listar_usuarios', 'AdminController@listar_usuarios');
Route::get('admin/data_listar_usuarios', 'AdminController@data_listar_usuarios');
Route::get('admin/data_listar_roles', 'AdminController@data_listar_roles');
Route::get('admin/listar_roles', 'AdminController@listar_roles');
Route::get('admin/create_rol', 'AdminController@create_rol');
Route::get('admin/roles/{id}/editar_roles_permisos', 'RoleController@editar_roles_permisos');

Route::get('admin/list_inventario', 'InventarioController@list_inventario');
Route::get('admin/data_listar_inventario', 'InventarioController@data_listar_inventario');
Route::get('admin/get_data_edit_inventario/{id_inventrio}', 'BienesController@getDataInventario');
Route::post('admin/updateInventItem', 'InventarioController@updateInventItem');//***
Route::post('admin/deleteUnico', 'InventarioController@deleteUnico');

Route::get('admin/alta_bienes', 'InventarioController@alta_bienes');
Route::post('admin/deleteBien', 'InventarioController@deleteBien');
Route::get('admin/create_seccion', 'InventarioController@create_seccion');
Route::post('admin/save_seccion', 'InventarioController@save_seccion');
Route::get('admin/listSeccion', 'InventarioController@listSeccion');
Route::get('admin/getSelectCausaAlta', 'InventarioController@getSelectCausaAlta');
Route::post('admin/save_causa_alta', 'InventarioController@save_causa_alta');
Route::get('admin/getSelectCatUso', 'InventarioController@getSelectCatUso');
Route::post('admin/save_uso', 'InventarioController@save_uso');
Route::post('admin/storeBien', 'InventarioController@storeBien');
Route::get('admin/data_listar_bienes', 'InventarioController@data_listar_bienes');
Route::get('inventario/imprimeEtiquetas', 'InventarioController@imprimeEtiquetas');
Route::post('admin/listBienes', 'InventarioController@listBienes');
Route::post('admin/storeBienInvent', 'InventarioController@storeBienInvent');
Route::post('admin/extractProgresivoMaxMin', 'InventarioController@extractProgresivoMaxMin');
Route::post('admin/storeMasivo', 'InventarioController@storeMasivo');
Route::get('inventario/selectEtiquetas', 'EtiquetasController@viewEtiquetas');
Route::post('inventario/getNumRows', 'EtiquetasController@getNumRows');
Route::post('inventario/getNroId', 'EtiquetasController@getNroId');
Route::post('admin/esUnicoProgresivo', 'InventarioController@esUnicoProgresivo');


Route::get('admin/list_eventos', 'EventosController@list_eventos');
Route::get('admin/editar_seccion', 'BienesController@editar_seccion');
Route::get('admin/get_data_edit_seccion/{id_bien}', 'BienesController@get_data_edit_seccion');
Route::post('admin/updateBien', 'BienesController@updateBien');



Route::get('admin/existencias', 'ExistenciasController@existencias');
Route::get('admin/data_listar_existencias', 'ExistenciasController@tableExistencias');

Route::get('admin/buscador', 'ExistenciasController@buscador');
Route::get('admin/get_datos_buscador/{nro_invent}', 'ExistenciasController@get_datos_buscador');


Route::post('admin/storeEventos', 'EventosController@storeEventos');
Route::get('admin/data_listar_eventos', 'EventosController@data_listar_eventos');
Route::get('admin/get_data_edit_evento/{id_event}', 'EventosController@get_data_edit_evento');
Route::post('admin/updateEvento', 'EventosController@updateEventPost');


Route::get('admin/agregar_bienes_eventos', 'EventosController@agregar_bienes_eventos');
Route::get('admin/regresar_bienes_eventos', 'EventosController@regresar_bienes_eventos');
Route::post('admin/listEventos', 'EventosController@getSelectEventos');
Route::post('admin/listInventario', 'EventosController@selectInventario');
Route::post('admin/addItemEvent', 'EventosController@addItemEvent');
Route::post('admin/getListTeam', 'EventosController@getListTeam');
Route::post('admin/getListResponsable', 'EventosController@getListResponsable');
Route::post('admin/insertEmpleado', 'EventosController@insertEmpleado');
Route::get('admin/listar_bienes_evento', 'EventosController@listar_bienes_evento');
Route::get('admin/listar_bienes_evento_salida', 'EventosController@listar_bienes_evento_salida');

Route::post('admin/unicoMuchos', 'EventosController@unicoMuchos');
//Route::get('admin/remover_bien_evento/{evento}/{id_clasifica}/{id_bien}/{unico}/{conteo}/{idInvent}/{inputRestar}/{observaciones}/{estado_fisico}','EventosController@remover_bien_evento');
Route::get('admin/remover_bien_evento/{evento}/{id_clasifica}/{id_bien}/{unico}/{conteo}/{idInvent}/{inputRestar}/{observaciones}/{estado_fisico}','EventosController@remover_bien_evento');
Route::get('admin/eliminar_bien_evento/{evento}/{id_clasifica}/{id_bien}/{unico}/{conteo}/{idInvent}/{inputRestar}','EventosController@eliminar_bien_evento');
Route::post('admin/cantidadExistente', 'EventosController@cantidadExistente');
Route::post('admin/itemReturnEvent', 'EventosController@itemReturnEvent');
Route::post('admin/deleteEmpleado', 'EventosController@deleteEmpleado');
Route::post('admin/cantidadEnEvento', 'EventosController@cantidadEnEvento');

Route::get('admin/getTotalNumbers', 'ExistenciasController@getTotalNumbers');
Route::get('admin/InventDisponibles', 'ExistenciasController@InventDisponibles');
Route::get('admin/bienesEnUso', 'ExistenciasController@bienesEnUso');











Route::group(['middleware' => ['role:SuperAdmin|admin']], function() {
    Route::group(['prefix' => 'requisiciones'], function() {

        /********************************************/
        Route::post('home','RequisicionesController@guardarCargo')->name('inicio');
        Route::get('/reqRegistrar', 'RequisicionesController@reqRegistrar');
        Route::post('/getDataSol','RequisicionesController@getDataSol');
        Route::post('/getMyReqAlm','RequisicionesController@getMyReqAlm');
        Route::get('/deleteReqBien/{idSolBien}', 'RequisicionesController@deleteReqBien');
        Route::get('/deleteReqFol/{folio}', 'RequisicionesController@deleteReqFol');
        Route::post('/storeSolicitud','RequisicionesController@storeMySolicitud');
        Route::post('/getUnidad','RequisicionesController@getUnidad');
        Route::post('/storeRequisicion','RequisicionesController@storeRequisicion');
        
        Route::post('/getMyReqFolProveedor','RequisicionesController@getMyReqFolProveedor');
        Route::post('/getParPreTotal','RequisicionesController@getParPreTotal');
        Route::post('/getCabmsTotal','RequisicionesController@getCabmsTotal');
        /*NEW REGISTER REQ*/
        Route::get('/captureReq', 'RequisicionesController@captureReq');
        /*FORMULARIO DE PROPUESTA - ANEXO TECNICO DE BIENES*/
        Route::get('/formAnexo','RequisicionesController@formAnexo');
        Route::get('/getpdf/{folio}/{status}/{tipo}', 'RequisicionesController@data')->name('pdf');
        Route::post('/data_validation','RequisicionesController@signed');
        Route::post('/rechazar','RequisicionesController@rechazar');
        Route::get('/data_validation/{path}/signed', 'RequisicionesController@getSignedPdf')->name('data_signed');
        /********************************************/

    });
});

Route::group(['middleware' => ['role:SuperAdmin|admin']], function() {
    Route::group(['prefix' => 'newRequisiciones'], function() {
        Route::get('/createReq', 'NewRequisicionesController@captureReq');
        Route::post('/getMyReqFol','NewRequisicionesController@getMyReqFol');
    });
});


    //editar usuarios
    Route::group(['prefix' => 'users'], function() {
        Route::get('/profile', 'UserController@profile');
        Route::get('/index', 'UserController@index');
        Route::get('/forgotpass', 'UserController@forgotpass');
        Route::post('/updatePassword', 'UserController@updatePassword');
        Route::post('/validPassword', 'UserController@validPassword');
        Route::post('/validUser', 'Auth\RegisterController@validUser');
        Route::post('/validEmail', 'Auth\RegisterController@validEmail');
        //Route::post('/editUser', 'UserController@editUser');
    });

    //Resource para subir archivo
    Route::resource('files', 'FileController');
    //Route::get('/files/show', 'FileController@show');
    /*Route::get('test', function() {
        dd(DB::connection()->getPdo());
    });*/

});


Route::get('/block_screen', function () {
  return view('usuarios/block_screen');
});
Route::post('/block_screen', function () {
    return response()
    ->json(['status' => 'true']);
});

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
