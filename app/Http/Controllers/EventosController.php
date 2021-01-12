<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Eventos;
use App\Existencias;
use App\ConteoEnEvento;
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
        //->join('bienes', 'inventario.id_clasifica', '=', 'bienes.id_clasificacion')
        ->rightJoin('bienes', function($join){  //Join multiples matchs  ***************** *****/*/*/*/*/*/*/
                     $join->on('inventario.id_clasifica', '=', 'bienes.id_clasificacion')
                          ->on('bienes.id', '=', 'inventario.id_bien');
                   })
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
                /*$invent = Inventario::select('inventario.id as idInvent','inventario.id', 'secciones.descripcion as descClasif', 
                    'bienes.descripcion as descBien', 'inventario.factura', 'precio', 'progresivo',
                    'unico', 'conteo'
                    ,'progresivo', 'inventario.id_clasifica', 'inventario.id_bien')
                ->leftJoin('bienes','inventario.id_bien','=','bienes.id')
                ->leftJoin('secciones','bienes.id_clasificacion','=','secciones.id_seccion')
                ->where('inventario.id_evento', $request->evento_id)
                ->get()->toArray();*/
                $invent = DB::select(
                    'select conteo_en_evento.id as idInvent, secciones.descripcion as descClasif, 
                    bienes.descripcion as descBien, 1 as unico, conteo_evento as conteo, 
                    inventario.id_clasifica, inventario.id_bien, inventario.id as idOrigin
                    from conteo_en_evento
                                        join inventario on conteo_en_evento.id_clasifica = inventario.id_clasifica 
                                        and conteo_en_evento.id_bien = inventario.id_bien
                    left join bienes on conteo_en_evento.id_bien = bienes.id 
                    left join secciones on bienes.id_clasificacion = secciones.id_seccion
                    where conteo_en_evento.id_evento =  '. $request->evento_id .'
                    union
                    select inventario.id as idInvent, secciones.descripcion as descClasif, 
                    bienes.descripcion as descBien, unico, conteo, id_clasifica, id_bien, inventario.id as idOrigin
                    from inventario left join bienes on inventario.id_bien = bienes.id 
                    left join secciones on bienes.id_clasificacion = secciones.id_seccion 
                     where inventario.id_evento = '. $request->evento_id
                     );
            }
            else
            {
                //dd(3);
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

        if($request->codigoInvent !='')//si existe codigo escaneado
        {   

            if($existencias->unico == 1)//si es unico mostrar  mensaje
            {   
                //evaluar si ya agregaron la cantidad a restar
                if($request->boxNumberInput != '')
                {   
                    $invT = Inventario::select('*')->where('id',$request->codigoInvent)->first();
                    //dd($invT);
                    $existencias = Existencias::select('*')
                    ->where('id_clasifica',$invT->id_clasifica)
                    ->where('id_bien',$invT->id_bien)->first();

                    $inventario = Inventario::select('*')->where('id',$request->codigoInvent)
                    ->update([
                            'conteo' => $existencias->conteo_existencia - $request->boxNumberInput,
                            'id_evento' => $request->id_inventario
                            ]);
                    
                    $conteoEvento = new ConteoEnEvento;
                    $conteoEvento->id_clasifica = $invT->id_clasifica;                    
                    $conteoEvento->id_bien = $invT->id_bien;                    
                    $conteoEvento->conteo_evento = $request->boxNumberInput;                    
                    $conteoEvento->id_evento = $request->evento;                    
                    $conteoEvento->status = 1;
                    $conteoEvento->save();

                    $existenciaMenos = $existencias->conteo_existencia - $request->boxNumberInput;
                    $existencias->update(['conteo_existencia' => $existenciaMenos]);
                    $mensaje ='Registro exitoso';
                }
                else
                {
                    //dd(3);
                    $respuesta = array('resp' => false, 'mensaje' => "Indicar cantidad a asignar");
                    return   $respuesta;
                //break;
                }
                
            }
            else
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
               
            
        }
        else
        {   //resta por cantidad de un registro unico
            if($request->boxNumberInput > 0)
            {
                $existencias = Existencias::select('*')
                ->where('id_clasifica',$request->id_clasifica)
                ->where('id_bien',$request->id_bien)->first();
                //dd($existencias);
                //dd($request->boxNumberInput);
                $inventario = Inventario::select('*')->where('id',$request->idInventUnico)
                //->get()->ToArray();
                //dd($inventario);
                ->update([
                        'conteo' => $existencias->conteo_existencia - $request->boxNumberInput,
                        'id_evento' => $request->id_inventario
                        ]);
                $conteoEvento = new ConteoEnEvento;
                    $conteoEvento->id_clasifica = $request->id_clasifica;                    
                    $conteoEvento->id_bien = $request->id_bien;                    
                    $conteoEvento->conteo_evento = $request->boxNumberInput;                    
                    $conteoEvento->id_evento = $request->evento;                    
                    $conteoEvento->status = 1;
                    $conteoEvento->save();
                //dd($existencias->conteo_existencia);
                $existenciaMenos = $existencias->conteo_existencia - $request->boxNumberInput;
                $existencias->update(['conteo_existencia' => $existenciaMenos]);
                $mensaje ='Registro exitoso';

            }
            else
            {
                $existencias = Existencias::select('*')
            ->where('id_clasifica',$request->id_clasifica)
            ->where('id_bien',$request->id_bien)->first();
                //registro por seleccion de combos
                $inventario = Inventario::select('*')->where('id',$request->id_inventario)
                ->update(['status' => 2, 'id_evento' => $request->evento]);
                //dd($existencias->conteo_existencia);
                $existenciaMenos = $existencias->conteo_existencia - 1;
                $existencias->update(['conteo_existencia' => $existenciaMenos]);
                $mensaje ='Registro exitoso';
            }
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

        return response()->json($campoUnico);

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

    public function remover_bien_evento($id_event,$id_clasifica,$id_bien,$unico,$conteo)
    {
            //dd($conteo);
        $getExistActual = Existencias::select('conteo_existencia')
        ->where('id_clasifica',$id_clasifica)
        ->where('id_bien',$id_bien)->get()->toArray();

        if($unico == 1)
        {
            $idUp =    Inventario::where('id_clasifica',$id_clasifica)
            ->where('id_bien',$id_bien);
            
            $idUp->update(['conteo' =>  $getExistActual[0]['conteo_existencia'] + $conteo]);

            $existUp = Existencias::where('id_clasifica',$id_clasifica)
            ->where('id_bien',$id_bien);
            $existUp->update([
                'conteo_existencia' => $getExistActual[0]['conteo_existencia'] + $conteo
            ]);

            $resg = ConteoEnEvento::where('id_clasifica', '=', $id_clasifica)
            ->where('id_bien', '=', $id_bien)->first();
            $resg->delete();
        }
        else
        {
            
            $idUp =    Inventario::where('id',$id_event);
            $idUp->update(['id_evento' => 0,'status' =>  1]);

            $existUp = Existencias::where('id_clasifica',$id_clasifica)
            ->where('id_bien',$id_bien);

            $existUp->update([
                'conteo_existencia' => $getExistActual[0]['conteo_existencia'] + $conteo
            ]);

        }
        
        //dd($bienes);
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   response()->json($respuesta);
    }

    public function cantidadExistente(Request $request)
    {
        if($request->codigoInvent !='')
        {
            $campoUnico = Inventario::select('inventario.id as idInvent','conteo',
            DB::raw('case when conteo is null then \'0\' else conteo end as conteo_a'))
            ->where('id', $request->codigoInvent)
            ->get()->toArray();
        }
        else
        {
            $campoUnico = Inventario::select('inventario.id as idInvent','conteo',
            DB::raw('case when conteo is null then \'0\' else conteo end as conteo_a'))
            ->where('id_clasifica', $request->val_clasif)
            ->where('id_bien', $request->id_bien)
            ->where('unico', 1)
            ->get()->toArray();
        }
        




        //dd($campoUnico);

        return response()->json($campoUnico);

    }
    
}
