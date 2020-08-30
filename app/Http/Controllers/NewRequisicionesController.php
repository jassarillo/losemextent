<?php 
namespace App\Http\Controllers;
//Haciendo Uso de Modelos
use App\Almacenes;
use App\CambsTotal;
use App\CatProveedores;
use App\Cotizaciones;
use App\CotizacionesBienes;
use App\FoliosDepen;
use App\ParPreTotal;
use App\Requisiciones;
use App\RequisicionesBienes;
use App\Sellos;
use App\UnidadMedida;
use App\Usuarios;
use Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Mail;
use Session;

class NewRequisicionesController extends Controller {

	public function captureReq() {
		$sesDep = Session::get('depD');
		//$cabmsGRP = CambsTotal::select('cabms','descripcion')
		//->orderBy('descripcion', 'asc')->get()->toArray();

		$unidadM = UnidadMedida::select('id', 'descripcion')
			->orderBy('descripcion', 'asc')->get()->toArray();

		$almacenes = Almacenes::select('id', 'calle', 'colonia')
			->where('dependencia', $sesDep)
			->orderBy('calle', 'asc')
		//->groupBy('id','calle', 'colonia')
			->get()->toArray();
		//dd($almacenes);
		return view('requisiciones/createReq', ['unidadM' => $unidadM, 'almacenes' => $almacenes]);
	}


	public function getMyReqFol(Request $request) {

		$userId = auth()->user();
		//dd($userId);
		if ($request->user == "autoriza") {
			$campo = "solicitudes.status";
			$oper = "=";
			$filtro = true;
		} elseif ($request->user == "entrega") {
			$campo = "id_userautoriza";
			$oper = ">=";
			$filtro = 1;
		} else {
			$campo = "usr_solicita";
			$oper = "=";
			$filtro = $userId->id;

		}
		//     dd($filtro);
		//    dd($request);

		$myReg = Requisiciones::orderBy('no_requisicion', 'DESC')
		->join('users', 'requisiciones_new.usr_solicita', '=', 'users.id')
		->where($campo, $oper, $filtro)
		->where('requisiciones_new.status_req', 0)
		->get()->toArray();
		//dd($myReg);
		return response()->json($myReg);
	}


}
