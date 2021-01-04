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
use App\TeamEvento;
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



    //For DataTable
    public function data_listar_eventos(){
        //dd(3232);
        $eventos = Eventos::select('*')
        ->get()->toArray();
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
        ->where('inventario.status',1)
        ->where('id_clasifica',$request->val_clasif)
        ->where('id_bien',$request->id_bien)
        ->get()->toArray();
        //dd($inventario);
        return response()->json($inventario);
    }

    public function listar_bienes_evento(Request $request){

        //dd($request);
        if($request->inicio == null)
        { //dd(3);
            $invent = Inventario::select('*')->take(0)->get()->toArray();
        }   
        else
        {
            //dd($request->eligeSeccion);

            if($request->eligeBien == 0)
            {
                //dd(2);
                $invent = Inventario::select('inventario.id as idInvent','inventario.id', 'secciones.descripcion as descClasif', 
                    'bienes.descripcion as descBien', 'inventario.factura', 'precio', 'progresivo',
                    'unico', 'conteo'
                    ,'progresivo', 'id_clasifica', 'id_bien')
                ->leftJoin('bienes','inventario.id_bien','=','bienes.id')
                ->leftJoin('secciones','bienes.id_clasificacion','=','secciones.id_seccion')
                ->where('inventario.id_evento', $request->evento_id)
                //->where('inventario.id_clasifica', $request->eligeSeccion)
                ->get()->toArray();
            }
            else
            {
                dd(3);
                $invent = Inventario::select('inventario.id as idInvent','inventario.id', 'secciones.descripcion as descClasif', 
                    'bienes.descripcion as descBien', 'inventario.factura', 'precio', 'progresivo',
                    'unico', 'conteo'
                    ,'progresivo', 'id_clasifica', 'id_bien')
                ->leftJoin('bienes','inventario.id_bien','=','bienes.id')
                ->leftJoin('secciones','bienes.id_clasificacion','=','secciones.id_seccion')
                ->where('inventario.id_clasifica', $request->eligeSeccion)
                ->where('inventario.id_bien', $request->eligeBien)
                ->get()->toArray();

            }
        }    

        return Datatables::of($invent)->toJson();   

    }

    public function addItemEvent(Request $request)
    {
        //dd($request->id_inventario);
        //$request->evento

        $existencias = Inventario::select('*')
        ->where('id',$request->codigoInvent)
        ->where('status',1)
        ->first();

        //dd($existencias->id);

        if($request->codigoInvent !='')
        {
            if(!$existencias)
            {
               $mensaje = 'Elemento no disponible';
               //dd($mensaje);
            }
            else
            {
                //Registro por codigo scanner
                $idClean = ltrim($request->codigoInvent, '0');
                //dd($request->evento);
                $inventario = Inventario::select('*')
                ->where('id',$idClean)->update(['status' => 2, 'id_evento' => $request->evento]);

                $existencias = Existencias::select('*')
                ->where('id_clasifica',$existencias->id_clasifica)
                ->where('id_bien',$existencias->id_bien)->first();
                //resta elemento a existencias
                $existenciaMenos = $existencias->conteo_existencia - 1;
                $existencias->update(['conteo_existencia' => $existenciaMenos]);
                $mensaje = 'Registro exitoso';
            }    
            
        }
        else
        {
            //registro por seleccion de combos
            $inventario = Inventario::select('*')->where('id',$request->id_inventario)->update(['status' => 2, 'id_evento' => $request->id_inventario]);

            $existencias = Existencias::select('*')
            ->where('id_clasifica',$request->id_clasifica)
            ->where('id_bien',$request->id_bien)->first();
            //dd($existencias->conteo_existencia);
            $existenciaMenos = $existencias->conteo_existencia - 1;
            $existencias->update(['conteo_existencia' => $existenciaMenos]);
            $mensaje ='Registro exitoso';
        }

 

        //dd($inventario);
        $respuesta = array('resp' => true, 'mensaje' => $mensaje);
        return   $respuesta;

    }

    
    public function getListTeam(Request $request)
    {
        
        $teaEvent = Eventos::select('eventos.id as id_event', 'destino', 'nombre_completo')
        ->Join('team_evento','team_evento.id_evento', '=', 'eventos.id')
        ->Join('empleados',  'empleados.nro_empleado', '=','team_evento.id_empleado')
        ->where('eventos.id', $request->idEvento)
        ->groupBy('eventos.id','destino', 'nombre_completo')
        ->get()->toArray();
        //dd($teaEvent);
        return response()->json($teaEvent);

    }
    
    public function insertEmpleado(Request $request)
    {
        
        $saveEvent = new TeamEvento;
        $saveEvent->id_evento = $request->teamEvento;
        $saveEvent->id_empleado = $request->nro_empleado;
        $saveEvent->status = 1;
        $saveEvent->save();
        $mensaje = '';

        $respuesta = array('resp' => true, 'mensaje' => $mensaje);
        return   $respuesta;
    }

    public function unicoMuchos(Request $request)
    {
        $campoUnico = Inventario::select('unico')
        ->where('id_clasifica', $request->val_clasif)
        ->where('id_bien', $request->id_bien)
        ->get()->toArray();

        //dd($campoUnico);

        return response()->json($teaEvent);

    }

    public function get_data_edit_evento($id_event){
        //dd($id_event);
        $evento = Eventos::select('*')
        ->where('id',$id_event)
        ->get()->toArray();
        //dd($bienes);
        return response()->json($evento);
    }

    public function updateEventPost(Request $request)
    {
        $id_update =$request->id_update; 
        $eventUp =    Eventos::where('id',$id_update);
        //$bajaUP = $baja;
        $eventUp->update(
          ['destino' => $request->destino_e,
            'fecha' =>  $request->fecha_e,
            'hora' =>  $request->hora_e,
            'descripcion' => $request->descripcion_e,
            'lugar' => $request->lugar_e
                 ]);

        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;
    }

    public function remover_bien_evento($id_event,$id_clasifica,$id_bien){
        //dd($id_event);
        $idUp =    Inventario::where('id',$id_event);
        $idUp->update(['id_evento' => 0,'status' =>  1]);

        $getExistActual = Existencias::select('conteo_existencia')
        ->where('id_clasifica',$id_clasifica)
        ->where('id_bien',$id_bien)->get()->toArray();
        //dd($getExistActual[0]['conteo_existencia']);

        $existUp = Existencias::where('id_clasifica',$id_clasifica)
        ->where('id_bien',$id_bien);
        //dd($existUp);
        $existUp->update(['conteo_existencia' => $getExistActual[0]['conteo_existencia'] +1]);


        //dd($bienes);
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   response()->json($respuesta);
    }
    
}
