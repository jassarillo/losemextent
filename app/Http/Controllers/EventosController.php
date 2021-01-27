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
use App\ResponsableEvento;
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
        ->whereNull('status')->orderBy('updated_at', 'desc')
        ->get()->toArray();
        //$eventos = DB::select('Select * from eventos order by id desc');
        //dd($eventos);
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

    public function regresar_bienes_eventos(){
        return view('eventos.regresar_bienes_eventos');
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
               
                $invent = DB::select(
                    'select conteo_en_evento.id as idInvent, secciones.descripcion as descClasif, 
                    bienes.descripcion as descBien, conteo_evento as conteo, 
                    id_clasifica, id_bien, id_inventario as idOrigin, conteo_en_evento.status, conteo_en_evento.unico,observaciones,estado_fisico, conteo_en_evento.updated_at
                    from conteo_en_evento      
                    left join bienes on conteo_en_evento.id_bien = bienes.id 
                    left join secciones on bienes.id_clasificacion = secciones.id_seccion
                    where conteo_en_evento.id_evento =  '. $request->evento_id 
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

        public function listar_bienes_evento_salida(Request $request){

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
              //dd(454);
                $invent = DB::select(
                    'select conteo_en_evento.id as idInvent, secciones.descripcion as descClasif, 
                    bienes.descripcion as descBien, conteo_evento as conteo, 
                    id_clasifica, id_bien, id_inventario as idOrigin, conteo_en_evento.status, conteo_en_evento.unico
                    from conteo_en_evento      
                    left join bienes on conteo_en_evento.id_bien = bienes.id 
                    left join secciones on bienes.id_clasificacion = secciones.id_seccion
                    where conteo_en_evento.id_evento =  '. $request->evento_id 
                     );

             
            }
            else
            {
                //dd(3333);

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
                    $conteoEvento->id_inventario = $request->codigoInvent;              
                    $conteoEvento->conteo_evento = $request->boxNumberInput;                    
                    $conteoEvento->id_evento = $request->evento_e;                    
                    $conteoEvento->status = 1;
                    $conteoEvento->unico = $invT->unico;
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
                    //dd(3333);
                    //Registro por codigo scanner
                    $idClean = ltrim($request->codigoInvent, '0');
                    //dd($request->evento_e);
                    $inventario = Inventario::select('*')
                    ->where('id',$idClean)->update(['status' => 2, 'id_evento' => $request->evento_e]);

                    $existencias = Existencias::select('*')
                    ->where('id_clasifica',$existencias->id_clasifica)
                    ->where('id_bien',$existencias->id_bien)->first();
                    //resta elemento a existencias
                    $existenciaMenos = $existencias->conteo_existencia - 1;
                    $existencias->update(['conteo_existencia' => $existenciaMenos]);

                    $conteoEvento = new ConteoEnEvento;
                    $conteoEvento->id_clasifica = $existencias->id_clasifica;                    
                    $conteoEvento->id_bien = $existencias->id_bien;                    
                    $conteoEvento->id_inventario = $request->codigoInvent;                    
                    $conteoEvento->conteo_evento = 1;                    
                    $conteoEvento->id_evento = $request->evento_e;                    
                    $conteoEvento->status = 1;
                    $conteoEvento->unico = 0;
                    $conteoEvento->save();
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
//dd(454545);
                $conteoEvento = new ConteoEnEvento;
                    $conteoEvento->id_clasifica = $request->id_clasifica;                    
                    $conteoEvento->id_bien = $request->id_bien;                    
                    $conteoEvento->id_inventario = $request->idInventUnico;                    
                    $conteoEvento->conteo_evento = $request->boxNumberInput;                    
                    $conteoEvento->id_evento = $request->evento_e;                    
                    $conteoEvento->unico = 1;                    
                    $conteoEvento->status = 1;
                    $conteoEvento->save();
                //dd($existencias->conteo_existencia);
                $existenciaMenos = $existencias->conteo_existencia - $request->boxNumberInput;
                $existencias->update(['conteo_existencia' => $existenciaMenos]);
                $mensaje ='Registro exitoso';

            }
            else
            {
                //dd($request->id_inventario);
                $existencias = Existencias::select('*')
            ->where('id_clasifica',$request->id_clasifica)
            ->where('id_bien',$request->id_bien)->first();
                //registro por seleccion de combos
                $inventario = Inventario::select('*')->where('id',$request->id_inventario)
                ->update(['status' => 2, 'id_evento' => $request->evento_e]);
                //dd($existencias->conteo_existencia);
                $existenciaMenos = $existencias->conteo_existencia - 1;

                $conteoEvento = new ConteoEnEvento;
                    $conteoEvento->id_clasifica = $existencias->id_clasifica;                    
                    $conteoEvento->id_bien = $existencias->id_bien;                    
                    $conteoEvento->id_inventario = $request->id_inventario;                    
                    $conteoEvento->conteo_evento = 1;                    
                    $conteoEvento->id_evento = $request->evento_e;                    
                    $conteoEvento->status = 1;
                    $conteoEvento->unico = 0;
                    $conteoEvento->save();

                $existencias->update(['conteo_existencia' => $existenciaMenos]);
                $mensaje ='Registro exitoso';
            }
        }

 

        //dd($inventario);
        $respuesta = array('resp' => true, 'mensaje' => $mensaje);
        return   $respuesta;

    }

    public function itemReturnEvent(Request $request)
    {
        //dd($request->codigoInvent);
        $esUnico =    Inventario::where('id',$request->codigoInvent)->first();
      //dd($esUnico->unico);

        $getConteo =  ConteoEnEvento::where('id_clasifica', '=', $esUnico->id_clasifica)
            ->where('id_bien', '=', $esUnico->id_bien)->first();
        $inputRestar = $request->inputRestar;
        $id_event = $request->evento;
        $unico = $esUnico->unico;
        $id_clasifica = $esUnico->id_clasifica;
        $id_bien = $esUnico->id_bien;
        $idInvent = $request->codigoInvent;
        $observaciones = $request->observaciones;
        $estado_fisico = $request->estado_fisico;
        if($esUnico->unico == 0)
        {
            //dd(33);
            $conteo = 1;
        }
        else
        {
            //dd(444);
            if(!$request->boxNumberInput)
            {
                //dd(34);
                $respuesta = array('resp' => false, 'mensaje' => "Indicar cantidad a asignar");
                return   $respuesta;

            }
            else
            {
                $conteo = $request->boxNumberInput;//$getConteo->conteo_evento;   
            }
            
        }
        


            return   $this->remover_bien_evento($id_event,$id_clasifica,$id_bien,$unico,
                $conteo,$idInvent,$inputRestar,$observaciones,$estado_fisico);
        
    }
    
    public function getListTeam(Request $request)
    {
        
        $teaEvent = Eventos::select('eventos.id as id_event', 'destino', 
            'empleados.nro_empleado','nombre_completo')
        ->Join('team_evento','team_evento.id_evento', '=', 'eventos.id')
        ->Join('empleados',  'empleados.nro_empleado', '=','team_evento.id_empleado')
        ->where('eventos.id', $request->idEvento)
        ->groupBy('eventos.id','destino','empleados.nro_empleado', 'nombre_completo')
        ->get()->toArray();
        //dd($teaEvent);
        return response()->json($teaEvent);

    }
    public function getListResponsable(Request $request)
    {
        
        $teaEvent = Eventos::select('eventos.id as id_event', 'destino', 
            'empleados.nro_empleado','nombre_completo')
        ->Join('responsable_evento','responsable_evento.id_evento', '=', 'eventos.id')
        ->Join('empleados',  'empleados.nro_empleado', '=','responsable_evento.id_empleado')
        ->where('eventos.id', $request->idEvento)
        ->groupBy('eventos.id','destino','empleados.nro_empleado', 'nombre_completo')
        ->get()->toArray();
        //dd($teaEvent);
        return response()->json($teaEvent);

    }

    
    
    public function insertEmpleado(Request $request)
    {
        if($request->nro_empleado != '')
        {
            $saveEvent = new TeamEvento;
            $saveEvent->id_evento = $request->teamEvento;
            $saveEvent->id_empleado = $request->nro_empleado;
            $saveEvent->status = 1;
            $saveEvent->save();
            $mensaje = '';
        }
        if($request->nro_empleado_responsable != '')
        {
            $saveEvent = new ResponsableEvento;
            $saveEvent->id_evento = $request->teamEvento;
            $saveEvent->id_empleado = $request->nro_empleado_responsable;
            $saveEvent->status = 1;
            $saveEvent->save();
            $mensaje = '';
        }
        

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

    public function remover_bien_evento($id_event,$id_clasifica,$id_bien,$unico,$conteo,$idInvent,$inputRestar,$observaciones,$estado_fisico)
    { //dd($idInvent);
            //dd($id_clasifica);
        $getExistActual = Existencias::select('conteo_existencia')
        ->where('id_clasifica',$id_clasifica)
        ->where('id_bien',$id_bien)->get()->toArray();

        if($unico == 1)
        {   
            //dd($id_event);
            //dd($inputRestar,$conteo);
            //dd($observaciones);
                $diferencia = $inputRestar - $conteo;
                //dd($diferencia);
                $idUp =    Inventario::where('id_clasifica',$id_clasifica)
                ->where('id_bien',$id_bien);
                
                $idUp->update(['conteo' =>  $getExistActual[0]['conteo_existencia'] + $conteo]);

                $existUp = Existencias::where('id_clasifica',$id_clasifica)
                ->where('id_bien',$id_bien);
                $existUp->update([
                    'conteo_existencia' => $getExistActual[0]['conteo_existencia'] + $conteo
                ]);

                if($inputRestar == $conteo)//si es igual, solo cambiar status
                {   //dd(3030);
                    $resg = ConteoEnEvento::where('id_clasifica', '=', $id_clasifica)
                    ->where('id_bien', '=', $id_bien)
                    ->where('id_evento',$id_event)->first();
                    //dd($resg);
                    $resg->update([
                                'conteo_evento' => $inputRestar,
                                'conteo_regreso' => $conteo,
                                'observaciones' => $observaciones,
                                'estado_fisico' => $estado_fisico,
                                'status' =>2
                    ]);
                    //dd($resg);
                    //$resg->delete(); 
                }
                else
                {
                    //dd(4040);
                    $resg = ConteoEnEvento::where('id_clasifica', '=', $id_clasifica)
                    ->where('id_bien', '=', $id_bien)->where('id_evento',$id_event)->first();
                    $resg->update([
                                'conteo_evento' => $inputRestar,
                                'conteo_regreso' => $conteo,
                                'observaciones' => $observaciones,
                                'estado_fisico' => $estado_fisico,
                                'status' =>2
                    ]);
                }
            
            }
            else
            {
                //Remover bien evento por click
                //dd(4343);
                //dd($idInvent);
                $getExistActual = Existencias::select('conteo_existencia')
                ->where('id_clasifica',$id_clasifica)
                ->where('id_bien',$id_bien)->get()->toArray();
                //dd($getExistActual);
                //$invId = ConteoEnEvento::where('id', '=', $idInvent)->first();
                //dd($invId);
                $idUp =    Inventario::where('id',$idInvent)->first();
                //dd($idUp);
                $idUp->update(['id_evento' => 0,'status' =>  1]);

                $existUp = Existencias::where('id_clasifica',$id_clasifica)
                ->where('id_bien',$id_bien)->first();
                //dd($existUp->conteo_existencia);
                $existUp->update([
                    'conteo_existencia' => $getExistActual[0]['conteo_existencia'] + $conteo
                ]);
                //dd("stop");
                //dd($idInvent);
                $resg = ConteoEnEvento::where('id_inventario', '=', $idInvent)
                        ->where('id_evento',$id_event)->first();
                        //dd($resg);
                        $resg->update([
                                    'conteo_evento' => $inputRestar,
                                    'observaciones' => $observaciones,
                                    'estado_fisico' => $estado_fisico,
                                    'status' =>2
                        ]);
               


                $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
                return   response()->json($respuesta);
                        

        }
        
        //dd($bienes);
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   response()->json($respuesta);
    }

    public function eliminar_bien_evento($id_event,$id_clasifica,$id_bien,$unico,
        $conteo,$idInvent,$inputRestar)
    {
        
        $getExistActual = Existencias::select('conteo_existencia')
        ->where('id_clasifica',$id_clasifica)
        ->where('id_bien',$id_bien)->get()->toArray();
        //dd($getExistActual);
            $invId = ConteoEnEvento::where('id', '=', $idInvent)->first();
            //dd($invId->id_inventario);
            $idUp =    Inventario::where('id',$invId->id_inventario)->first();
            //dd($idUp);
            $idUp->update(['id_evento' => 0,'status' =>  1]);

            $existUp = Existencias::where('id_clasifica',$id_clasifica)
            ->where('id_bien',$id_bien);

            $existUp->update([
                'conteo_existencia' => $getExistActual[0]['conteo_existencia'] + $conteo
            ]);

            $resg = ConteoEnEvento::where('id', '=', $idInvent)->first();
                    $resg->delete();

            $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
            return   response()->json($respuesta);
    }

    /*public function remove_bien_evento_click()
    {
         
            //dd(999);
            //dd($idInvent);
            $idUp =    Inventario::where('id',$idInvent)->first();
            //dd($idUp);
            $idUp->update(['id_evento' => 0,'status' =>  1]);

            $existUp = Existencias::where('id_clasifica',$id_clasifica)
            ->where('id_bien',$id_bien);

            $existUp->update([
                'conteo_existencia' => $getExistActual[0]['conteo_existencia'] + $conteo
            ]);

            $resg = ConteoEnEvento::where('id_clasifica', '=', $id_clasifica)
                    ->where('id_bien', '=', $id_bien)->first();
                    $resg->update([
                                'conteo_evento' => $inputRestar,
                                'status' =>2
                    ]);
                    
    }*/
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

    
    public function cantidadEnEvento(Request $request)
    {
            $invent = Inventario::select('*')
            ->where('id', $request->codigoInvent)->first();
            //dd($invent->id_clasifica);

            $campoUnico = ConteoEnEvento::select('id','conteo_evento as conteo',DB::raw('case when conteo_evento is null then \'0\' else conteo_evento end as conteo_a'))
            ->where('id_clasifica', $invent->id_clasifica)
            ->where('id_bien', $invent->id_bien)
            ->where('id_evento',$request->evento)
            ->where('status', 1)
            ->get()->toArray();

            //dd($campoUnico);

        
        return response()->json($campoUnico);
    }
    public function deleteEmpleado(Request $request)
    {   
        //id_empleado tipoEmpleado
        //dd($request->id_bien);
        $mensaje ="";
        if($request->tipoEmpleado == 1) //1 es Responsable
        {
            $RespEvento = ResponsableEvento::where('id_empleado',  $request->id_empleado)
            ->where('id_evento',$request->teamEvento)->first();
            $RespEvento->delete();
            
        }
        if($request->tipoEmpleado == 2)//2 Team Apoyo
        {
            
            $ApoyopEvento = TeamEvento::where('id_empleado', '=', $request->id_empleado)
            ->where('id_evento',$request->teamEvento)->first();
            $ApoyopEvento->delete();
        }
        //dd($fr);                            
        //dd($resg);
        $respuesta = array('resp' => true, 'mensaje' => 'Elemento eliminado');
        return   $respuesta;


    }
    
}
