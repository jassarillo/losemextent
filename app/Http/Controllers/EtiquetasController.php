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

class EtiquetasController extends Controller
{


    public function viewEtiquetas(){
        return view('inventario.viewEtiquetas');
    }

    public function getNumRows(Request $request)
    {

      
        $Resg = DB::table('inventario')
        //->where('id_bien', $request->id_bien)
        ->orderBy('id', 'desc')
        ->paginate(5);
        return response ()->json ($Resg);  
    }

}
