<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bienes;
use App\CausaAlta;
use App\CatUso;
use App\Secciones;
use App\Inventario;
use App\Existencias;
use App\Medidas;
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

    public function data_listar_inventario(Request $request){

        //dd($request->inicio);
        if($request->inicio == null)
        { 
            $invent = Inventario::select('*')->take(0)->get()->toArray();
        }   
        else
        {
            //dd($request->eligeSeccion);

            if($request->eligeBien == 0)
            {

                $invent = Inventario::select('inventario.id as idInvent','inventario.id', 'secciones.descripcion as descClasif', 
                    'bienes.descripcion as descBien', 'inventario.factura', 'precio', 'progresivo',
                    'unico', 'conteo'
                    ,'progresivo', 'id_clasifica', 'id_bien','rfc','r_social')
                ->leftJoin('bienes','inventario.id_bien','=','bienes.id')
                ->leftJoin('secciones','bienes.id_clasificacion','=','secciones.id_seccion')
                ->where('inventario.id_clasifica', $request->eligeSeccion)
                ->get()->toArray();
            }
            else
            {
                $invent = Inventario::select('inventario.id as idInvent','inventario.id', 'secciones.descripcion as descClasif', 
                    'bienes.descripcion as descBien', 'inventario.factura', 'precio', 'progresivo',
                    'unico', 'conteo'
                    ,'progresivo', 'id_clasifica', 'id_bien','rfc','r_social')
                ->leftJoin('bienes','inventario.id_bien','=','bienes.id')
                ->leftJoin('secciones','bienes.id_clasificacion','=','secciones.id_seccion')
                ->where('inventario.id_clasifica', $request->eligeSeccion)
                ->where('inventario.id_bien', $request->eligeBien)
                ->get()->toArray();

            }
        }    

        return Datatables::of($invent)->toJson();   

    }

    //For DataTable
    public function data_listar_bienes(){
        //dd(3232);
        $bienes = Bienes::select('*','bienes.id as idBien','secciones.descripcion as secDesc','bienes.descripcion as bienesDesc','cat_altas.descripcion as descAlta',
            'mAncho.descripcion as ancho_medidaD',
            DB::raw('case when ancho is null then \'0\' else ancho end as ancho'),
            DB::raw('case when mAncho.descripcion is null then \'\' else mAncho.descripcion end as ancho_medidaD'),
            DB::raw('case when largo is null then \'0\' else largo end as largo'),
            DB::raw('case when mLarg.descripcion is null then \'\' else mLarg.descripcion end as largo_medidaD'),
            DB::raw('case when alto is null then \'0\' else alto end as alto'),
            DB::raw('case when mAlto.descripcion is null then \'\' else mAlto.descripcion end as alto_medidaD'),
            DB::raw('case when diametro is null then \'0\' else diametro end as diametro'),
            DB::raw('case when mDiamet.descripcion is null then \'\' else mDiamet.descripcion end as diametro_medidaD'),
            DB::raw('case when peso is null then \'0\' else peso end as peso'),
            DB::raw('case when mPeso.descripcion is null then \'\' else mPeso.descripcion end as peso_medidaD'),
            DB::raw('case when volumen is null then \'0\' else volumen end as volumen'),
            DB::raw('case when mVol.descripcion is null then \'\' else mVol.descripcion end as volumen_medidaD'),
            DB::raw('case when calibre is null then \'0\' else calibre end as calibre'),
            DB::raw('case when mCal.descripcion is null then \'\' else mCal.descripcion end as calibre_medidaD'),
            DB::raw('extract(year from bienes.created_at) as year')
                )
        ->join('secciones','bienes.id_clasificacion', '=', 'secciones.id_seccion')
        ->join('cat_altas','cat_altas.id', '=', 'bienes.causa_alta')
        ->leftJoin('cat_medidas as mLarg','mLarg.id','=','bienes.largo_medida')
        ->leftJoin('cat_medidas as mAncho','mAncho.id','=','bienes.ancho_medida')
        ->leftJoin('cat_medidas as mAlto','mAlto.id','=','bienes.alto_medida')
        ->leftJoin('cat_medidas as mDiamet','mDiamet.id','=','bienes.diametro_medida')
        ->leftJoin('cat_medidas as mPeso','mPeso.id','=','bienes.peso_medida')
        ->leftJoin('cat_medidas as mVol','mVol.id','=','bienes.volumen_medida')
        ->leftJoin('cat_medidas as mCal','mCal.id','=','bienes.calibre_medida')
        ->get()->toArray();
        return Datatables::of($bienes)->toJson();
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

    public function listBienes(Request $request)
    {
        if($request->val_clasif == 0){
            $bienes = Bienes::select('id_clasificacion','bienes.id','bienes.alto','bienes.largo',
                'bienes.ancho','bienes.diametro','bienes.peso','bienes.volumen',
                'bienes.descripcion as descripcionB',
                'mLarg.descripcion as largo_medidaD',
                'mAncho.descripcion as ancho_medidaD','mAlto.descripcion as alto_medidaD',
                'mDiamet.descripcion as diametro_medidaD','mPeso.descripcion as peso_medidaD',
                'mVol.descripcion as volumen_medidaD')
            ->leftJoin('cat_medidas as mLarg','mLarg.id','=','bienes.largo_medida')
            ->leftJoin('cat_medidas as mAncho','mAncho.id','=','bienes.ancho_medida')
            ->leftJoin('cat_medidas as mAlto','mAlto.id','=','bienes.alto_medida')
            ->leftJoin('cat_medidas as mDiamet','mDiamet.id','=','bienes.diametro_medida')
            ->leftJoin('cat_medidas as mPeso','mPeso.id','=','bienes.peso_medida')
            ->leftJoin('cat_medidas as mVol','mVol.id','=','bienes.volumen_medida')
            ->get()->toArray();

            //$data = DB::select('select * from bienes');
           
            //+ opt.id_clasificacion +"-"+ opt.id + " " + opt.descripcion + ' largo: '+ opt.largo+
           //opt.largo_medida+ '- ancho: ' + opt.ancho_medida+'- alto: ' + opt.alto_medida
           //+'- diametro: ' + opt.diametro_medida +'- peso: ' + opt.peso_medida+ '- volumen: '
           //+ opt.volumen_medida
        }
        else
        {
            $bienes = Bienes::select('id_clasificacion','bienes.id','bienes.alto','bienes.largo',
                'bienes.ancho','bienes.diametro','bienes.peso','bienes.volumen',
                'bienes.descripcion as descripcionB',
                'mLarg.descripcion as largo_medidaD',
                'mAncho.descripcion as ancho_medidaD','mAlto.descripcion as alto_medidaD',
                'mDiamet.descripcion as diametro_medidaD','mPeso.descripcion as peso_medidaD',
                'mVol.descripcion as volumen_medidaD')
            ->leftJoin('cat_medidas as mLarg','mLarg.id','=','bienes.largo_medida')
            ->leftJoin('cat_medidas as mAncho','mAncho.id','=','bienes.ancho_medida')
            ->leftJoin('cat_medidas as mAlto','mAlto.id','=','bienes.alto_medida')
            ->leftJoin('cat_medidas as mDiamet','mDiamet.id','=','bienes.diametro_medida')
            ->leftJoin('cat_medidas as mPeso','mPeso.id','=','bienes.peso_medida')
            ->leftJoin('cat_medidas as mVol','mVol.id','=','bienes.volumen_medida')
            ->where('id_clasificacion',$request->val_clasif)
            ->get()->toArray();

           
/*
            $bienes = Bienes::select('*')
            ->where('id_clasificacion',$request->val_clasif)
            ->get()->toArray();*/
        }    
        
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

    
    public function deleteUnico(Request $request)
    { 
        //dd($request->id_bien);
        $resg = Inventario::where('id', '=', $request->id_invent)->first();
        $resg->delete();
        //dd($resg);
        $respuesta = array('resp' => true, 'mensaje' => 'Elemento eliminado');
        return   $respuesta;


    }

    public function deleteBien(Request $request)
    { 
        //dd($request->id_bien);
        $resg = Bienes::where('id', '=', $request->id_bien)->first();
        $resg->delete();
        $respuesta = array('resp' => true, 'mensaje' => 'Bien eliminado');
        return   $respuesta;


    }
    public function storeBien(Request $request)
    {
        //dd($request->descripcion);
      
        
        $saveBienes = Bienes::create($request->all());
      

        //dd($saveBienes);
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

        $lastId = Inventario::find(\DB::table('inventario')->max('id'));
        $saveBienes = new Inventario;
        $saveBienes->id = $lastId->id + 1;
        $saveBienes->id_clasificacion = $request->id_clasifica;
        $saveBienes->id_bien = $request->id_bien;
        $saveBienes->fecha_inventario = $request->fecha_inventario;
        $saveBienes->motivo_alta = $request->motivo_alta;
        $saveBienes->factura = $request->factura;
        $saveBienes->rfc = $request->rfc;
        $saveBienes->r_social = $request->r_social;
        $saveBienes->precio = $request->precio;
        $saveBienes->status = 1;
        $saveBienes->save();
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;

    }


    public function updateInventItem (Request $request)
    {
        
        
        $lastId = Inventario::where('id', '=', $request->id_invent_hiden)->get()->toArray(); 
        //dd($lastId);
        
        $updateUnico = Inventario::where('id','=',$request->id_invent_hiden)
                    ->where('id_bien', $lastId[0]['id_bien'])
                    ->where('id_clasifica',$lastId[0]['id_clasifica'])->first();
        //evaluamos si es unico
        if(!$request->unicoEdit){
            //dd(3);
            $updateUnico->update(['conteo_existencia' => $request->conteo_existencia , 
                                //'unico'=> $request->unicoEdit,
                                'fecha_inventario'=>$request->fecha_inventario_e,
                                'motivo_alta'=>$request->motivo_alta_e,
                                'factura'=>$request->factura_e,
                                'rfc'=>$request->rfc_e,
                                'r_social'=>$request->r_social_e,
                                'precio'=>$request->precio_e,
                                'conteo'=>$request->conteo_e
                                ]);  
        }
        else
        {//DB::raw('count(*) as user_count, status') 

        //dd(5);
            $countUnicoVal = Inventario::select('conteo')
                    ->where('unico',1)
                    ->where('id_bien', $lastId[0]['id_bien'])
                    ->where('id_clasifica',$lastId[0]['id_clasifica'])->get()->toArray();
                    //dd($countUnicoVal[0]['conteo']);

            $count = Inventario::select(DB::raw("count(*)  as count"))
                    ->where('id','!=',$request->id_invent_hiden)
                    ->where('id_bien', $lastId[0]['id_bien'])
                    ->where('id_clasifica',$lastId[0]['id_clasifica'])->get()->toArray();
                    //dd($count[0]['count']);

            $updateUnico->update(['conteo_existencia' => $request->conteo_existencia , 
                                'unico'=> 1,
                                'fecha_inventario'=>$request->fecha_inventario_e,
                                'motivo_alta'=>$request->motivo_alta_e,
                                'factura'=>$request->factura_e,
                                'precio'=>$request->precio_e,
                                'conteo'=>$count[0]['count'] + $countUnicoVal[0]['conteo']
                                ]); 

            $deleteOthers = Inventario::where('id','!=',$request->id_invent_hiden)
                    ->where('id_bien', $lastId[0]['id_bien'])
                    ->where('id_clasifica',$lastId[0]['id_clasifica'])->delete();

        }
                  

        

        //dd($updateUnico,$deleteOthers);
        
        $respuesta = array('resp' => true, 'mensaje' => 'Registro actualizado');
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

    public function esUnicoProgresivo(Request $request)
    {
           
        $data = Inventario::select(DB::raw("distinct unico as unico"))
        ->where('id_clasifica',$request->id_clasifica)
        ->where('id_bien',$request->id_bien)
        ->get()->toArray();

        if(!$data)
        {   
            $valor=100;
        }
        else
        {
                $valor =$data[0]['unico'];            
        }
        return response ()->json ( $valor );

    }

    public function extractProgresivoMaxMin(Request $request)
    {
        //dd($request->all());     
        
        $data = Inventario::select(DB::raw("max(progresivo) + 1 as numero"))
        ->where('id_bien',$request->id_bien)
        ->get();
            //dd($data);
        if($data[0]['numero'] =='')
        {
            $data[0]['numero'] =1;

        }
        return response ()->json ( $data );

    }

     public function storeMasivo(Request $request)
    {

            //dd("Ver donde colocar el inser a existencias");
            //dd($request->conteo);
            //dd($request->input());
            $veces =$request->conteo;
            for ($i = 0; $i < $veces ; $i++) 
            {

                //dd($request->id_bien);
                $data = Inventario::select(DB::raw("max(progresivo)  + 1 as numero"))
                ->where('id_bien',$request->id_bien)->get()->toArray();
                //dd($data[0]['numero']);
                if($data[0]['numero'] ==''){
                  $ProgresivoMas =  $data[0]['numero'] =1;
                }else { $ProgresivoMas =  $data[0]['numero'];}
                //dd($ProgresivoMas);
                //$progresivo = $ini; 
                if ($request->unico == true){
                    $unico = 1;
                }else {
                    $unico =0;
                }
                $lastId = Inventario::select(DB::raw("max(id)  + 1 as numero"))->get()->toArray();
                //dd($lastId[0]['numero']);
                $saveBienes = new Inventario;
                $saveBienes->id = $lastId[0]['numero'];
                $saveBienes->id_clasifica = $request->id_clasifica;
                $saveBienes->id_bien = $request->id_bien;
                $saveBienes->fecha_inventario = $request->fecha_inventario;
                $saveBienes->motivo_alta = $request->motivo_alta;
                $saveBienes->factura = $request->factura;
                $saveBienes->rfc = $request->rfc;
                $saveBienes->r_social = $request->r_social;
                $saveBienes->precio = $request->precio;
                $saveBienes->progresivo = $ProgresivoMas;
                $saveBienes->unico = $unico;
                $saveBienes->conteo = $request->conteo;
                $saveBienes->status = 1;
                $saveBienes->save();
                if ($request->unico == true){
                    break;
                }
            }

                //Verifica si existe un registro de este tipo
                $ifExiste = Existencias::select(DB::raw('COUNT(id) as num'),'conteo_existencia')
                ->where('id_clasifica',$request->id_clasifica)
                ->where('id_bien',$request->id_bien)
                ->groupBy('conteo_existencia')
                ->get()->toArray();
                //dd($ifExiste);
                if(!$ifExiste){ 

                    
                    $ConteoTodos = DB::select('select sum(distinct conteo) as uno from inventario 
                    where id_clasifica = '. $request->id_clasifica .' 
                    and id_bien = '. $request->id_bien .' and unico =0 ');
                    //dd($ConteoTodos[0]->uno);
                    $ConteoUnico = DB::select('select  sum(conteo) as dos from inventario 
                        where id_clasifica = '. $request->id_clasifica .'  
                        and id_bien = '. $request->id_bien .' and unico =1');
                    //dd($ConteoUnico[0]->dos);
                    $sumaTodo = $ConteoTodos[0]->uno + $ConteoUnico[0]->dos;

                    //sdd($sumaTodo);
                     $Existencias = new Existencias;
                        $Existencias->bodega = 1;
                        $Existencias->id_clasifica = $request->id_clasifica;
                        $Existencias->id_bien = $request->id_bien;
                        $Existencias->conteo_existencia = $sumaTodo ; 
                        $Existencias->save();
                    }else
                    {
                        if($ifExiste[0]['num'] == 0){
                            //dd($ifExiste[0]['num'],55);
                            $Existencias = new Existencias;
                            $Existencias->bodega = 1;
                            $Existencias->id_clasifica = $request->id_clasifica;
                            $Existencias->id_bien = $request->id_bien;
                            $Existencias->conteo_existencia = $request->conteo;
                            $Existencias->save();
                        }else{
                            //dd($ifExiste[0]['num'],66);
                            $sum =$ifExiste[0]['conteo_existencia'] + $request->conteo;
                            Existencias::where('id_clasifica',$request->id_clasifica)
                            ->where('id_bien',$request->id_bien)
                            ->update(['conteo_existencia' => $sum ]);

                            
                        }
                    }

                

      
        $respuesta = array('resp' => true, 'mensaje' => 'Registro exitoso');
        return   $respuesta;


    }

    public function imprimeEtiquetas()
    {   
        return PDF::loadView('inventario.pdf.etiquetas')
        ->stream('archivo.pdf');
    }




}
