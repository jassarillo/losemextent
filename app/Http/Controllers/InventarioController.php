<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class InventarioController extends Controller
{

   

    public function list_inventario(){
        return view('inventario.list_inventario');
    }

    public function data_listar_inventario(){
    	//dd(3232);
    	$users = User::all();
        return Datatables::of($users)->toJson();
    }

    public function alta_bienes(){
    	return view('inventario.alta_bienes');
    }

    public function create_seccion()
    {
        return view('modals.bienes.add_seccion');
    }

}
