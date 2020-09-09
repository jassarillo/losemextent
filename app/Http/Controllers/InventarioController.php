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


class InventarioController extends Controller
{

   

    public function list_inventario(){
        return view('inventario.list_inventario');
    }

    public function data_listar_inventario(){
    	//dd(3232);
    	$invent = Inventario::select('inventario.*','bienes.descripcion as descBien','secciones.descripcion as descClasif')
        ->leftJoin('bienes','bienes.id_clasificacion','=','inventario.id_clasifica')
        ->leftJoin('secciones','secciones.id_seccion','=','bienes.id_clasificacion')
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
    	//d($desc_seccion);
        $secciones = new Secciones;
        $secciones->descripcion = $desc_seccion;
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

    public function save_uso(Request $request)
    {
        $desc_uso = $request->desc_uso;
        //d($desc_uso);
        $secciones = new CatUso;
        $secciones->descripcion = $desc_uso;
        $secciones->save();
        $respuesta = array('resp' => true, 'mensaje' => 'Detalle Uso Agregado');
        return   $respuesta;

    }
    
    public function listSeccion()
    {
        $secciones = Secciones::select(['id_seccion','descripcion'])->get()->toArray();
        //dd($bienes);
        return response ()->json ($secciones);

    }

    public function listBienes()
    {
        $bienes = Bienes::select(['id','id_clasificacion','descripcion'])->get()->toArray();
        //dd($bienes);
        return response ()->json ($bienes);

    }
    public function getSelectCausaAlta()
    {
        
        $cAlta = CausaAlta::select(['id','descripcion'])->get()->toArray();
        //dd($bienes);
        return response()->json($cAlta);
    }
    public function getSelectCatUso()
    {
        
        $cUso = CatUso::select(['id','descripcion'])->get()->toArray();
        //dd($bienes);
        return response()->json($cUso);
    }

    public function storeBien(Request $request)
    {
        //dd($request->all());
      
        
        $saveBienes = Bienes::create($request->all());
      if ($request->hasFile('anexo_1')) {
            $fecha = Carbon::now();
            $y = $fecha->format('y');
              $file = Input::file('anexo_1');
              $nombre = $file->getClientOriginalName();
              $request->file('anexo_1')->move('uploads/inventarios_img/'.$y.'/', $saveBienes->id.'.jpg');
        }
        //dd($saveBienes->id);
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;
    }

    public function storeBienInvent(Request $request)
    {
            //$last = DB::table('items')->latest()->first();
        $lastId = Inventario::find(\DB::table('inventario')->max('id'));
        //$lastId = Inventario::whereRaw("select max(id) from inventario")->get();
        //dd($lastId->id);
        //$saveBienes = Inventario::create($request->all());
        $saveBienes = new Inventario;
        $saveBienes->id = $lastId->id + 1;
        $saveBienes->id_clasifica = $request->id_clasifica;
        $saveBienes->id_bien = $request->id_bien;
        $saveBienes->fecha_inventario = $request->fecha_inventario;
        $saveBienes->motivo_alta = $request->motivo_alta;
        $saveBienes->factura = $request->factura;
        $saveBienes->precio = $request->precio;
        //$saveBienes->conteo = $request->conteo;
        $saveBienes->save();
        
        //dd($saveBienes->id);
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;

    }

    public function data_list_inventario()
    {
        
            /*
            $view = \View::make('bienes.pdf.formRepABDF', compact('dependencias','depenAltas', 'depenBajas', 'depenDFinal', 'fecha_ini','fecha_fin'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('letter','landscape');

            return $pdf->stream('Bienes');
            */
    }
    public function imprimeEtiquetas()
    {   
        return PDF::loadView('inventario.pdf.etiquetas')
        ->stream('archivo.pdf');
    }


}
