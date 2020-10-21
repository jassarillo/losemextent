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

    public function data_listar_existencias(){
        //dd(3232);
        $existencias = Existencias::all();
        return Datatables::of($existencias)->toJson();
    }

}
