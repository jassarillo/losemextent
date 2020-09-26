<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bienes;
use App\CausaAlta;
use App\CatUso;
use App\Secciones;
use App\Inventario;
use App\Http\Requests\UserRequest;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\File;



class EventosController extends Controller
{


    public function list_eventos(){
        return view('eventos.list_eventos');
    }

    public function data_listar_inventario(){
    	//dd(3232);
    	/*$invent = Inventario::select('inventario.*','bienes.descripcion as descBien','secciones.descripcion as descClasif')
        ->leftJoin('bienes','bienes.id_clasificacion','=','inventario.id_clasifica')
        ->leftJoin('secciones','secciones.id_seccion','=','bienes.id_clasificacion')
        ->get()->toArray();*/

        $invent = Inventario::select('inventario.id', 'secciones.descripcion as descClasif', 
                'bienes.descripcion as descBien', 'inventario.factura', 'precio', 'progresivo','unico', 'conteo'
                ,'progresivo')
        ->leftJoin('bienes','inventario.id_bien','=','bienes.id')
        ->leftJoin('secciones','bienes.id_clasificacion','=','secciones.id_seccion')
        ->get()->toArray();

        return Datatables::of($invent)->toJson();
    }

    //For DataTable
    public function data_listar_bienes(){
        //dd(3232);
        $users = Bienes::all();
        return Datatables::of($users)->toJson();
    }

    public function alta_bienes(){
    	return view('bienes.alta_bienes');
    }

    public function create_seccion()
    {
        return view('modals.bienes.add_seccion');
    }

    public function save_seccion(Request $request)
    {
    	$desc_seccion = $request->desc_seccion;
        $lastIdSeccion = Secciones::find(\DB::table('secciones')->max('id'));
    	//d($desc_seccion);
        $secciones = new Secciones;
        $secciones->descripcion = $desc_seccion;
        $secciones->id_seccion = $lastIdSeccion->id +1 ;
        $secciones->save();
        $respuesta = array('resp' => true, 'mensaje' => 'Seccion Agregada');
        return   $respuesta;

    }

    public function save_causa_alta(Request $request)
    {
        $desc_causa_alta = $request->desc_causa_alta;
        //d($desc_causa_alta);
        $secciones = new CausaAlta;
        $secciones->descripcion = $desc_causa_alta;
        $secciones->save();
        $respuesta = array('resp' => true, 'mensaje' => 'Causa Alta agregada');
        return   $respuesta;

    }





}
