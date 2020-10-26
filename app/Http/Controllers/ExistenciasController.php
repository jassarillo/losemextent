<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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



class ExistenciasController extends Controller
{


    public function existencias(){
        return view('inventario.existencias');
    }

    public function tableExistencias(){
        //dd(3232);
        
        $existencias = Existencias::select('existencias.id','bodega', 'existencias.id_clasifica', 'se.descripcion as descSeccion', 'existencias.id_bien', 'bi.descripcion as descBien', 
        	'conteo_existencia','existencias.created_at')
        ->leftJoin('secciones as se','existencias.id_clasifica','=','se.id_seccion')
        ->leftJoin('bienes as bi','existencias.id_bien','=','bi.id')
        ->get()->toArray();
        //dd($existencias);
        return Datatables::of($existencias)->toJson();
    }

}
