<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Empleados;
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



class EmpleadosController extends Controller
{


    public function alta_empleados(){
        return view('empleados.alta_empleados');
    }


    //For DataTable
    public function data_listar_empleados(){
    
        $empleados = Empleados::select('*')
        ->get()->toArray();
       
        return Datatables::of($empleados)->toJson();
    }

    public function alta_bienes(){
    	return view('bienes.alta_bienes');
    }

    public function get_data_edit_empleado($idEmpleado)
    {
        $empleados = Empleados::select('*')
        ->where('id',$idEmpleado)
        ->get()->toArray();

        return response()->json($empleados);
    }

    public function altaEmpleado(Request $request)
    {
       $saveBienes = Empleados::create($request->all());
        
        //dd($saveBienes->destino);
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;
    }

    public function editEmpleado(Request $request)
    {
        $id_update = $request->id_update;
        $eventUp =    Empleados::where('id',$id_update);
        //$bajaUP = $baja;
        $eventUp->update(
          ['nro_empleado' => $request->nro_empleado_e,
            'nombre_completo' =>  $request->nombre_completo_e,
            'direccion' =>  $request->direccion_e,
            'email' => $request->email_e,
            'telefono' => $request->telefono_e,
            'edad' => $request->edad_e
                 ]);

        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;
    }

    public function eliminar_empleado($idEmpleado)
    {
        $resg = Empleados::where('id', '=', $idEmpleado)->first();
        $resg->delete();

        $respuesta = array('resp' => true, 'mensaje' => 'Elemento eliminado');
        return   $respuesta;
    }

    
}
