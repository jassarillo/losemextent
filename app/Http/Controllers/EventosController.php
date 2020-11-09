<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Eventos;
use App\Existencias;
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
   

        $invent = Inventario::select('inventario.id', 'secciones.descripcion as descClasif', 
                'bienes.descripcion as descBien', 'inventario.factura', 'precio', 'progresivo','unico', 'conteo'
                ,'progresivo')
        ->leftJoin('bienes','inventario.id_bien','=','bienes.id')
        ->leftJoin('secciones','bienes.id_clasificacion','=','secciones.id_seccion')
        ->get()->toArray();

        return Datatables::of($invent)->toJson();
    }

    //For DataTable
    public function data_listar_eventos(){
        //dd(3232);
        $eventos = Eventos::all();
        return Datatables::of($eventos)->toJson();
    }

    public function alta_bienes(){
    	return view('bienes.alta_bienes');
    }

    public function storeEventos(Request $request)
    {
        //dd($request->descripcion);
      
        
        $saveBienes = Eventos::create($request->all());
        
        //dd($saveBienes->destino);
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;
    }
    

    public function agregar_bienes_eventos(){
        return view('eventos.bienes_eventos');
    }

    public function getSelectEventos()
    {
        
        $eventos = Eventos::select(['id','destino'])->get()->toArray();
        //dd($bienes);
        return response()->json($eventos);
    }
    

    public function selectInventario(Request $request)
    {
        //dd($request->val_clasif);
        $inventario = Inventario::select(['inventario.id','inventario.id_clasifica','inventario.id_bien','inventario.progresivo','bienes.descripcion'])
        ->join('bienes', 'inventario.id_clasifica', '=', 'bienes.id_clasificacion')
        ->where('id_clasifica',$request->val_clasif)
        ->where('id_bien',$request->id_bien)
        ->get()->toArray();
        //dd($inventario);
        return response()->json($inventario);
    }


}
