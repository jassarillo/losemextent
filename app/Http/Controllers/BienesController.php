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
use Milon\Barcode\DNS1D;
//use Milon\Barcode\DNS1D;

class BienesController extends Controller
{


    public function viewEtiquetas(){
        return view('inventario.viewEtiquetas');
    }

   public function editar_seccion()
   { 
       
        return view('modals.bienes.mod_edit_bien');
   }

   public function get_data_edit_seccion($id_bien)
   { 
        //dd($id_bien);
        $bien = Bienes::select('*')
        ->where('id',$id_bien)
        ->get()->toArray();
        //dd($bienes);
        return response()->json($bien);
   }

   public function updateBien(Request $request)
    {
        $id_update =$request->id_update; 

        
        $bienUp =    Bienes::where('id',$id_update);
        //$bajaUP = $baja;
        $bienUp->update(
          ['descripcion' => $request->descripcion_e,
            'observacion' =>  $request->observacion_e,
            'causa_alta' =>  $request->causa_alta_e,
            'fecha_alta' => $request->fecha_alta_e,
            'estado' => $request->estado_e,
            'largo' => $request->largo_e,
            'largo_medida' => $request->largo_e_medida,
            'ancho' => $request->ancho_e,
            'ancho_medida' => $request->ancho_e_medida,
            'alto' => $request->alto_e,
            'alto_medida' => $request->alto_e_medida,
            'diametro' => $request->diametro_e,
            'diametro_medida' => $request->diametro_e_medida,
            'peso' => $request->peso_e,
            'peso_medida' => $request->peso_e_medida,
            'calibre' => $request->calibre_e,
            'calibre_medida' => $request->calibre_e_medida,
            'volumen' => $request->volumen_e,
            'volumen_medida' => $request->volumen_e_medida,
            'uso_material' => $request->uso_material_e,
                 ]);
        //$saveBienes = Bienes::create($request->all());
        //dd($saveBienes);
      if ($request->hasFile('anexo_1')) {
            $fecha = Carbon::now();
            $y = $fecha->format('y');
              $file = Input::file('anexo_1');
              $nombre = $file->getClientOriginalName();
              $request->file('anexo_1')->move('uploads/inventarios_img/'.$y.'/', $id_update.'.jpg');
        }
        //dd($saveBienes->id);
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;
    }

    public function getDataInventario($id_inventrio){
        $bien = Inventario::select('*')
        ->where('id',$id_inventrio)
        ->get()->toArray();
        //dd($bienes);
        return response()->json($bien);
    }
    

}
