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

/*class RequisicionesController extends Controller {
		public function captureReq() {
		$sesDep = Session::get('depD');

		$unidadM = UnidadMedida::select('id', 'descripcion')
			->orderBy('descripcion', 'asc')->get()->toArray();

		$almacenes = Almacenes::select('id', 'calle', 'colonia')
			->where('dependencia', $sesDep)
			->orderBy('calle', 'asc')
		//->groupBy('id','calle', 'colonia')
			->get()->toArray();
		//dd($almacenes);
		return view('requisiciones/createReq');
	}*/
	public function reqRegistrar() {
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
		return view('requisiciones.reqRegistrarNew', ['unidadM' => $unidadM, 'almacenes' => $almacenes]);
	}
	public function getUnidad(Request $request) {

		$nroEmp = $request->cabms_grp;
		$dato = explode("|", $nroEmp);

		$Unidad = UnidadMedida::select('descripcion')
			->where('id', $request->cabms_grp)
			->get()->toArray();
		return response()->json($Unidad);
	}
	public function getUnidadTodos(Request $request) {

		//dd("few");
		if ($request->paramTipo > 1) {
			if ($request->paramTipo == 2) {$ff = 91;} elseif ($request->paramTipo == 3) {$ff = 92;}
			$campo = "id";
			$operador = "=";
			$filtro = $ff;
		} else {
			$campo = "id";
			$operador = "<";
			$filtro = 90;
		}

		$Unidad = UnidadMedida::select('descripcion', 'id')
			->where($campo, $operador, $filtro)
			->get()->toArray();
		return response()->json($Unidad);
	}
	public function storeRequisicion(Request $request) {
		$nroEmp = $request->cabms_grp;
		$dato = explode("|", $nroEmp);

		//dd($request);
		$areaSS = Session::get('areaSS'); //Obtener id Area
		$sesDep = Session::get('depD'); //Obtener id Dependencia
		//dd('fghfeg');
		if ($request->id_folio == 0) {
			$noFol = FoliosDepen::select('folio_req')->where('clave_num', $sesDep)
				->get()->toArray();
			$userId = auth()->user();
			//dd($noFol[0]['folio_req']);
      if($request->hasFile('archivo')) {
        $adjunto = 1;
      }else{
        $adjunto = 0;
      }


			if ($request->tipo_req == 1) {
				$lugarEntrega = $request->almacen;
			} else {
				$lugarEntrega = $request->lugar_entrega;
			}
			$reqNew = new Requisiciones;
			$reqNew->dependencia = $sesDep;
			$reqNew->fecha_elabora = Carbon::now();
			$reqNew->fecha_requiere = $request->fecha_requiere;
			$reqNew->status_req = 0;
			$reqNew->no_requisicion = $noFol[0]['folio_req'] + 1;
			$reqNew->usr_solicita = $userId->id;
			$reqNew->tipo_req = $request->tipo_req;
			$reqNew->par_pre = $request->par_pre;
			$reqNew->observaciones = $request->observaciones;
			$reqNew->lugar_entrega = $lugarEntrega;
      $reqNew->monto_estimado = $request->monto_estimado;
			$reqNew->adjunto = $adjunto;
			$reqNew->status = 1;
			$reqNew->save();

			$folRequest = $noFol[0]['folio_req'] + 1;
			$folDepen = FoliosDepen::where('folio_req', '=', $noFol[0]['folio_req'])
				->where('clave_num', $sesDep)->first();
			//dd($folDepen);
			$noFolMas = $noFol[0]['folio_req'] + 1;
			$folDepen->update(['folio_req' => $noFolMas]);

			if ($request->hasFile('archivo')) {

				$fecha = Carbon::now();
				$m = $fecha->format('m');
				$y = $fecha->format('y');
				$file = Input::file('archivo');
				$nombre = $file->getClientOriginalName();
				$request->file('archivo')->move('uploads/Requisiciones/' . $sesDep . '/' . $y . '/' . $m . '/' . $folRequest, $folRequest . '_' . 'req.pdf');

			}
		} else {
			$folRequest = $request->id_folio;
		}

		$BienesNewsol = new RequisicionesBienes;
		$BienesNewsol->dependencia = $sesDep;
		$BienesNewsol->no_requisicion = $folRequest;
		$BienesNewsol->id_cabmsgrp = $dato[0];
		$BienesNewsol->cantidad = $request->cantidad;
		$BienesNewsol->status = 1;
		$BienesNewsol->unidad = $request->u_medida;
		$BienesNewsol->save();

		return response()->json($folRequest);
	}
	public function getDataSol(Request $request) {
		//dd($request->folio);
		$sol = Requisiciones::select('*')
			->where('no_requisicion', $request->folio)
			->get()->toArray();
		//dd($sol);
		return response()->json($sol);
	}
	public function getMyReqAlm(Request $request) {

		//->rightjoin('existencias','cat_cabmsgrp.clave_grp','=','existencias.id_cabmsgrp')
		$userId = auth()->user();
		$myReg = Requisiciones::select('requisiciones_bienes.id as idSolBien', 'requisiciones_bienes.id_cabmsgrp', 'cantidad', 'cat_cabmstotal.descripcion', 'cat_unidadalm.descripcion as descUnidad', 'fecha_requiere')
			->join('requisiciones_bienes', 'requisiciones.no_requisicion', '=', 'requisiciones_bienes.no_requisicion')
			->join('cat_cabmstotal', 'requisiciones_bienes.id_cabmsgrp', '=', 'cat_cabmstotal.cabms')
			->leftjoin('cat_unidadalm', 'cat_unidadalm.id', '=', 'requisiciones_bienes.unidad')
			->where('requisiciones.status', true)
			->where('requisiciones_bienes.no_requisicion', $request->folio)
			->orderBy('requisiciones.id', 'asc')->get()->toArray();

		return response()->json($myReg);
	}
	public function getMyReqFolProveedor(Request $request) {

		if ($request->tipo_req) {
			$tipo_req = $request->tipo_req;
			$comparReq = '=';

		} else {
			$tipo_req = 0;
			$comparReq = '>=';
		}

		if ($request->par_pre > 0) {
			$par_pre = $request->par_pre;
			$comparePar = '=';
		} else {
			$par_pre = 0;
			$comparePar = '>=';
		}
		//     dd($filtro);
		//    dd($request);

		$myReg = Requisiciones::select('fecha_requiere', 'requisiciones.no_requisicion', 'lugar_entrega', 'tipo_req',
			'cat_parpretotal.descripcion as parDesc')
			->join('requisiciones_bienes', 'requisiciones.no_requisicion', '=', 'requisiciones_bienes.no_requisicion')
			->join('cat_cabmstotal', 'requisiciones_bienes.id_cabmsgrp', '=', 'cat_cabmstotal.cabms')
			->join('cat_parpretotal', 'cat_cabmstotal.par_pre', '=', 'cat_parpretotal.par_pre')
			->where([
				['tipo_req', $comparReq, $tipo_req],
				['cat_cabmstotal.par_pre', $comparePar, $par_pre],
			])
			->where('status_req', 4)
		//->where('requisiciones.status',true)
			->groupBy('fecha_requiere', 'requisiciones.no_requisicion', 'lugar_entrega', 'tipo_req',
				'cat_parpretotal.descripcion')
			->orderBy('no_requisicion', 'desc')
			->get()->toArray();
		///dd($myReg);
		return response()->json($myReg);
	}
	public function getMyReqFol(Request $request) {
		//dd("rrr");

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

			->join('users', 'requisiciones.usr_solicita', '=', 'users.id')
			->where($campo, $oper, $filtro)
			->where('requisiciones.status_req', 0)
			->get()->toArray();
			dd($myReg);
		return response()->json($myReg);
	}
  
	public function deleteReqBien($idSolBien) {
		//dd($idBienes);
		$resg = RequisicionesBienes::where('id', '=', $idSolBien)->first();
		$resg->delete();
		return response()->json("OK");
	}
	public function deleteReqFol($folio) {
		//dd($idBienes);
		$resg = Requisiciones::where('no_requisicion', '=', $folio)->first();
		$resg->update(['status' => false]);
		return response()->json("OK");
	}
	//******* Tramitar Requisición ***********
	public function reqTramitar(Request $request) {
		//dd($request);

		if (request()->has('statusReq')) {
			//dd(request('statusReq'));
			$data = Requisiciones::select('no_requisicion', 'usersol.nombre as nombresol', 'fecha_elabora', 'usr_tramita', 'usr_solicita', 'usr_autorm', 'usr_autodf', 'fecha_requiere', 'fecha_tramita',
				'userTram.nombre as nombreTram', 'status_req', 'adjunto')
				->leftJoin('users as usersol', 'requisiciones.usr_solicita', '=', 'usersol.id')
				->leftJoin('users as userTram', 'requisiciones.usr_tramita', '=', 'userTram.id')
				->where('status_req', request('statusReq'))
			//->where('status_req',2)
				->orderBy('no_requisicion', 'DESC')->paginate(10);

		} else {
			$data = Requisiciones::select('no_requisicion', 'usersol.nombre as nombresol', 'fecha_elabora', 'usr_tramita', 'usr_solicita', 'usr_autorm', 'usr_autodf', 'fecha_requiere', 'fecha_tramita',
				'userTram.nombre as nombreTram', 'status_req', 'adjunto')
				->leftJoin('users as usersol', 'requisiciones.usr_solicita', '=', 'usersol.id')
				->leftJoin('users as userTram', 'requisiciones.usr_tramita', '=', 'userTram.id')
				->whereIn('status_req', [1, 2])
				->orderBy('no_requisicion', 'DESC')->paginate(10);
			//dd($data);
		}

		//dd($datos);
		$status_req = $request->statusReq;
		return view('requisiciones.reqTramitar', compact('data', 'status_req'));
	}
	//****** AJAX - Extrae Requisiciones Pendientes por validar **********
	public function getReqPend($statusReq) {
		/*
			          if ($request->ajax()) {
			        dd('ehghgh');
			      }
			         $data =Requisiciones::select('no_requisicion','usersol.nombre as nombresol','fecha_elabora','usr_tramita','usr_solicita',
			          'usr_autorm','usr_autodf','fecha_requiere','fecha_tramita','userTram.nombre as nombreTram','status_req')
			        ->leftJoin('users as usersol','requisiciones.usr_solicita','=','usersol.id')
			        ->leftJoin('users as userTram','requisiciones.usr_tramita','=','userTram.id')
			        ->where('status_req',$statusReq)
			        ->orderBy('no_requisicion','DESC')->paginate(10);
			        //dd($myReg);
			        return response()->json($data);
		*/
	}
	//******* Autorizar Requisición RM ***********
	public function reqAutorizaRM(Request $request) {
		//dd($request,'hola');
		if (request()->has('statusReq')) {

			$data = Requisiciones::select('no_requisicion', 'usersol.nombre as nombresol', 'fecha_elabora', 'usr_tramita', 'usr_solicita', 'usr_autorm', 'usr_autodf', 'fecha_requiere', 'fecha_tramita',
				'userTram.nombre as nombreTram', 'status_req', 'fecha_autorm', 'user_autoRM.nombre as nombre_autoRM', 'adjunto')
				->leftJoin('users as usersol', 'requisiciones.usr_solicita', '=', 'usersol.id')
				->leftJoin('users as userTram', 'requisiciones.usr_tramita', '=', 'userTram.id')
				->leftJoin('users as user_autoRM', 'requisiciones.usr_autorm', '=', 'user_autoRM.id')
				->where('status_req', request('statusReq'))
			//->where('status_req',2)
				->orderBy('no_requisicion', 'DESC')->paginate(10);

		} else {
			$data = Requisiciones::select('no_requisicion', 'usersol.nombre as nombresol', 'fecha_elabora', 'usr_tramita', 'usr_solicita', 'usr_autorm', 'usr_autodf', 'fecha_requiere', 'fecha_tramita',
				'userTram.nombre as nombreTram', 'status_req', 'adjunto')
				->leftJoin('users as usersol', 'requisiciones.usr_solicita', '=', 'usersol.id')
				->leftJoin('users as userTram', 'requisiciones.usr_tramita', '=', 'userTram.id')

				->whereIn('status_req', [2, 3])
				->orderBy('no_requisicion', 'DESC')->paginate(10);
		}
		$status_req = $request->statusReq;
		return view('requisiciones.reqAutorizaRM', compact('data', 'status_req'));
	}
	//******* Autorizar Requisición DGA ***********
	public function reqAutorizaDGA() {
		//dd(request());
		if (request()->has('statusReq')) {
			$status_req = 3;
			$data = Requisiciones::select('no_requisicion', 'usersol.nombre as nombresol', 'fecha_elabora', 'usr_tramita', 'usr_solicita', 'usr_autorm', 'usr_autodf', 'fecha_requiere', 'fecha_tramita',
				'userTram.nombre as nombreTram', 'status_req', 'fecha_autorm', 'user_autoRM.nombre as nombre_autoRM',
				'user_autoDF.nombre as nombre_df', 'fecha_autodf', 'adjunto')
				->leftJoin('users as usersol', 'requisiciones.usr_solicita', '=', 'usersol.id')
				->leftJoin('users as userTram', 'requisiciones.usr_tramita', '=', 'userTram.id')
				->leftJoin('users as user_autoRM', 'requisiciones.usr_autorm', '=', 'user_autoRM.id')
				->leftJoin('users as user_autoDF', 'requisiciones.usr_autodf', '=', 'user_autoDF.id')
				->where('status_req', request('statusReq'))
			//->where('status_req',2)
				->orderBy('no_requisicion', 'DESC')->paginate(10);
			//dd($data[0]->status_req);

		} else {
			$status_req = 4;
			$data = Requisiciones::select('no_requisicion', 'usersol.nombre as nombresol', 'fecha_elabora', 'usr_tramita', 'usr_solicita', 'usr_autorm', 'usr_autodf', 'fecha_requiere', 'fecha_tramita',
				'userTram.nombre as nombreTram', 'status_req', 'fecha_autorm', 'user_autoRM.nombre as nombre_autoRM', 'adjunto')
				->leftJoin('users as usersol', 'requisiciones.usr_solicita', '=', 'usersol.id')
				->leftJoin('users as userTram', 'requisiciones.usr_tramita', '=', 'userTram.id')
				->leftJoin('users as user_autoRM', 'requisiciones.usr_autorm', '=', 'user_autoRM.id')
				->whereIn('status_req', [3, 4])
			//->where('status_req',2)
				->orderBy('no_requisicion', 'DESC')->paginate(10);

		}
		//dd($data);

		return view('requisiciones.reqAutorizaDGA', compact('data', 'status_req'));
	}
	public function data($folio, $statusReq, $tipo) {
		//dd($folio, $statusReq, $tipo);
		$id = $folio;
		//dd($folio);
		return view('view_data.index', ['pdf' => base64_encode(Storage::get($this->generatePDF($id, $statusReq, $tipo))), 'id' => $id, 'status_req' => $statusReq, 'tipo' => $tipo]);
	}
	public function generatePDF($id, $status_req, $tipo) {

		switch ($status_req) {
		case 1:
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);
			$rfc = Auth::user()->rfc;

			//dd($data[0]->monto_estimado);
			$user = DB::select('select * from formatos_usuarios where rfc =:rfc ', ["rfc" => $rfc]);
			$data2 = DB::select('select * from sellos where id_requisicion =:id', ["id" => $id]);
			//dd($data2);

			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$path = public_path();
			//$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			/*if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}*/

			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$date = Carbon::now();
			$namePath = 'preview/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			//dd($namePath);

			if (Storage::disk('local')->exists($namePath)) {
				return $namePath;

			}

			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_solicita', ['data' => $data], compact('dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'user', 'tipo', 'data2'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();

		/*	$path = Storage::disk('local')->put($namePath, $pdf);
			if ($path && Storage::disk('local')->exists($namePath)) {
				return $namePath;
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}*/
      //dd(1);
			break;

		case 0:
  
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);

			$data2 = DB::select('select * from sellos where id_requisicion =:id', ["id" => $id]);

			//$rfc = Auth::user()->rfc;
			//dd($rfc);

			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$path = public_path();
			$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}
			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$date = Carbon::now();
			$namePath = 'preview/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			if (Storage::disk('local')->exists($namePath)) {
				return $namePath;
			}
			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_tramita', ['data' => $data], compact('dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'data2', 'tipo', 'adjunto'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();

			$path = Storage::disk('local')->put($namePath, $pdf);
			if ($path && Storage::disk('local')->exists($namePath)) {

				return $namePath;
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}
			break;

		case 2:
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);

			$data2 = DB::select('select * from sellos where id_requisicion =:id', ["id" => $id]);
			$rfc = Auth::user()->rfc;
			//dd($rfc);
			$user = DB::select('select * from formatos_usuarios where rfc =:rfc ', ["rfc" => $rfc]);

			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$path = public_path();
			$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}
			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$date = Carbon::now();
			$namePath = 'preview/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			if (Storage::disk('local')->exists($namePath)) {
				return $namePath;

			}
			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_autoriza', ['data' => $data], compact('dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'data2', 'user', 'tipo', 'adjunto'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();

			$path = Storage::disk('local')->put($namePath, $pdf);
			if ($path && Storage::disk('local')->exists($namePath)) {

				return $namePath;
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}
			break;

		case 3:
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);

			$data2 = DB::select('select * from sellos where id_requisicion =:id', ["id" => $id]);

			$rfc = Auth::user()->rfc;
			//dd($rfc);
			$user = DB::select('select * from formatos_usuarios where rfc =:rfc ', ["rfc" => $rfc]);
			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$path = public_path();
			$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}
			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$date = Carbon::now();
			$namePath = 'preview/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			if (Storage::disk('local')->exists($namePath)) {
				return $namePath;
			}
			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_autorizadf', ['data' => $data], compact('dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'data2', 'user', 'tipo', 'adjunto'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();

			$path = Storage::disk('local')->put($namePath, $pdf);
			if ($path && Storage::disk('local')->exists($namePath)) {

				return $namePath;
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}
			break;

		case 4:
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);

			$data2 = DB::select('select * from sellos where id_requisicion =:id', ["id" => $id]);
			//dd($data, $data2);
			$rfc = Auth::user()->rfc;
			//dd($rfc);
			$user = DB::select('select * from formatos_usuarios where rfc =:rfc ', ["rfc" => $rfc]);
			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$path = public_path();
			$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}

			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$date = Carbon::now();
			$namePath = 'preview/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			if (Storage::disk('local')->exists($namePath)) {
				return $namePath;
			}
			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_autorizadf_vp', ['data' => $data], compact('dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'data2', 'tipo', 'adjunto'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();

			$path = Storage::disk('local')->put($namePath, $pdf);
			if ($path && Storage::disk('local')->exists($namePath)) {

				return $namePath;
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}
			break;

		}
	}
	public function signed(Request $request) {

		$collect = collect($data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $request['id']]));

		$cadena_remplace = substr_replace($collect . '||', '||', 0, 0);

		$cadena_implode = implode('|', (array) $cadena_remplace);

		$cadena_comas = str_replace(',', '||', $cadena_implode);
		$cadena_original_corchete_llave_abrir = str_replace('[{', '', $cadena_comas);
		$cadena_original_corchete_llave_cerrar = str_replace('}]', '', $cadena_original_corchete_llave_abrir);
		$cadena_original = str_replace('"', '', $cadena_original_corchete_llave_cerrar);
		//$cadena_original = base64_encode($cadena_original);

		$tokenId = strtoupper('FPRUPRUEBA');
		$key = Session()->get('key');
		$cer = Session()->get('cer');
		$password = Session()->get('password');
		//$cadena = '||hola';
		$status_req = $request['status_req'];
		$tipo = $request['tipo'];

		$data = "{\r\n  \"security\":\r\n  {\r\n    \"tokenId\":\"" . $tokenId . "\"\r\n  },\r\n  \"data\":\r\n  {\r\n    \"password\":\"" . base64_encode($password) . "\",\r\n    \"cadena\":\"" . $cadena_original . "\",\r\n    \"byteKey\":\"" . base64_encode($key) . "\",\r\n    \"bytecer\":\"" . base64_encode($cer) . "\"\r\n  }\r\n}";

		$curl = curl_init();

		#Los campos editables solo son: CURLOPT_PORT, CURLOPT_URL y CURLOPT_CUSTOMREQUEST.

		curl_setopt_array($curl, array(

			CURLOPT_PORT => "9005",

			CURLOPT_URL => "http://10.1.181.25/eFirma/firmaCadena",

			CURLOPT_RETURNTRANSFER => true,

			CURLOPT_ENCODING => "",

			CURLOPT_MAXREDIRS => 10,

			CURLOPT_TIMEOUT => 30,

			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

			CURLOPT_CUSTOMREQUEST => "POST",

			CURLOPT_POSTFIELDS => $data,

			CURLOPT_HTTPHEADER => array(

				"Content-Type: application/json; charset=utf-8",

				"Accept:application/json, text/javascript, */*; q=0.01"),

		));

		//dd($curl);

		#Se cacha la respuesta y el error si es que existiera en cuestiones de conectividad

		$response = curl_exec($curl);
		#El resultado lo decodifico a un Json para poder extraer los valores del arreglo
		//dd($response);
		$response = json_decode($response);
		$err = curl_error($curl);

		#Se cierra el recurso cURL y se liberan recursos del sistema.

		curl_close($curl);

		#Saco informacion del arreglo y la asigno a variables para pasarlas a la siguiente función
		$err = $response->error->code;
		$cadenaOriginal = $response->data->cadenaOriginal;
		$folioConsulta = $response->data->folioConsulta;
		$fechaFirma = $response->data->fechaFirma;
		$nombreCompleto = $response->data->nombreCompleto;
		$sello = $response->data->sello;

		#Validación de errores

		if ($err != 0) {
			return redirect()->back()->with('error', $sign['error']['msg'] . ' , verifica que tu certificado y contraseña sean validos.');
		}
		$path = $this->generatePDFfirmado($request->input('id'), $cadenaOriginal, $folioConsulta, $fechaFirma, $nombreCompleto, $sello, $status_req, $tipo);
		//dd($path);
		return \Redirect::route('data_signed', $path)->with('success', 'obtenido correctamente');
	}
	public function generatePDFfirmado($id, $cadenaOriginal, $folioConsulta, $fechaFirma, $nombreCompleto, $sello, $status_req, $tipo) {

		switch ($status_req) {
		case 0:
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);
			$rfc = Auth::user()->rfc;
			//dd($rfc);
			$user = DB::select('select * from formatos_usuarios where rfc =:rfc ', ["rfc" => $rfc]);
			//dd($user);
			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$puesto = $user[0]->puesto;
			$path = public_path();
			$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}
			// dd($data);

			//dd($dia_elabora);
			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$date = Carbon::now();
			$namePathsigned = 'signed/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			if (Storage::disk('local')->exists($namePathsigned)) {
				return $namePathsigned;
			}

			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_signed_solicita', ['data' => $data], compact('cadenaOriginal', 'folioConsulta', 'fechaFirma', 'nombreCompleto', 'sello', 'dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'user', 'adjunto'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();

			$path = Storage::disk('local')->put($namePathsigned, $pdf);
			if ($path && Storage::disk('local')->exists($namePathsigned)) {
				$status_req = $status_req + 1;
				//dd($data['usr_solicita']);
				DB::table('requisiciones')->where('no_requisicion', $id)->update(['status_req' => $status_req]);
				Sellos::insert(['id_requisicion' => $id,
					'dependencia' => $data[0]->dependencia,
					'nombre_solicita' => $nombreCompleto,
					'puesto_solicita' => $puesto,
					'cadena_original_solicita' => $cadenaOriginal,
					'folio_consulta_solicita' => $folioConsulta,
					'sello_solicita' => $sello,
					'fecha_firma_solicita' => $fechaFirma,
					'status' => 0]);
				return base64_encode($namePathsigned);
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}
			break;

		case 1:
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);

			$data2 = DB::select('select * from sellos where id_requisicion =:id', ["id" => $id]);

			$rfc = Auth::user()->rfc;
			//dd($rfc);
			$user = DB::select('select * from formatos_usuarios where rfc =:rfc ', ["rfc" => $rfc]);
			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$puesto = $user[0]->puesto;
			$path = public_path();
			$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}

			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$qr = $data['qr'] = url('/') . '/validate_signed/' . base64_encode($folioConsulta);
			$date = Carbon::now();
			$namePathsigned = 'signed/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			if (Storage::disk('local')->exists($namePathsigned)) {
				return base64_encode($namePathsigned);
			}
			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_signed_tramita', ['data' => $data], compact('cadenaOriginal', 'folioConsulta', 'fechaFirma', 'nombreCompleto', 'sello', 'data2', 'dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'data', 'puesto', 'adjunto'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();
			$path = Storage::disk('local')->put($namePathsigned, $pdf);
			if ($path && Storage::disk('local')->exists($namePathsigned)) {
				$status_req = $status_req + 1;
				//dd($data['usr_solicita']);
				DB::table('requisiciones')->where('no_requisicion', $id)->update(['status_req' => $status_req, 'fecha_tramita' => $date, 'usr_tramita' => Auth::user()->id]);
				DB::table('sellos')->where('id_requisicion', $id)->update(['nombre_tramita' => $nombreCompleto,
					'puesto_tramita' => $puesto,
					'cadena_original_tramita' => $cadenaOriginal,
					'folio_consulta_tramita' => $folioConsulta,
					'sello_tramita' => $sello,
					'fecha_firma_tramita' => $fechaFirma]);

				return base64_encode($namePathsigned);
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}
			break;

		case 2:
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);

			$data2 = DB::select('select * from sellos where id_requisicion =:id', ["id" => $id]);
			$rfc = Auth::user()->rfc;
			//dd($rfc);
			$user = DB::select('select * from formatos_usuarios where rfc =:rfc ', ["rfc" => $rfc]);

			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$puesto = $user[0]->puesto;
			$path = public_path();
			$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}

			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$qr = $data['qr'] = url('/') . '/validate_signed/' . base64_encode($folioConsulta);
			$date = Carbon::now();
			$namePathsigned = 'signed/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			if (Storage::disk('local')->exists($namePathsigned)) {
				return base64_encode($namePathsigned);
			}
			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_signed_autoriza', ['data' => $data], compact('cadenaOriginal', 'folioConsulta', 'fechaFirma', 'nombreCompleto', 'sello', 'dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'data2', 'puesto', 'adjunto'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();
			$path = Storage::disk('local')->put($namePathsigned, $pdf);
			if ($path && Storage::disk('local')->exists($namePathsigned)) {
				$status_req = $status_req + 1;
				//dd($data['usr_solicita']);
				DB::table('requisiciones')->where('no_requisicion', $id)->update(['status_req' => $status_req, 'fecha_autorm' => $date, 'usr_autorm' => Auth::user()->id]);
				DB::table('sellos')->where('id_requisicion', $id)->update(['nombre_autoriza' => $nombreCompleto,
					'puesto_autoriza' => $puesto,
					'cadena_original_autoriza' => $cadenaOriginal,
					'folio_consulta_autoriza' => $folioConsulta,
					'sello_autoriza' => $sello,
					'fecha_firma_autoriza' => $fechaFirma]);

				return base64_encode($namePathsigned);
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}
			break;

		case 3:
			$data = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);

			$data2 = DB::select('select * from sellos where id_requisicion =:id', ["id" => $id]);

			$rfc = Auth::user()->rfc;
			//dd($rfc);
			$user = DB::select('select * from formatos_usuarios where rfc =:rfc ', ["rfc" => $rfc]);
			$fecha_elabora = explode("-", $data[0]->fecha_elabora);
			$fecha_requiere = explode("-", $data[0]->fecha_requiere);

			$dia_elabora = $fecha_elabora[2];
			$mes_elabora = $fecha_elabora[1];
			$anio_elabora = $fecha_elabora[0];
			$dia_requiere = $fecha_requiere[2];
			$mes_requiere = $fecha_requiere[1];
			$anio_requiere = $fecha_requiere[0];
			$puesto = $user[0]->puesto;
			$path = public_path();
			$namefile = $path . '/uploads/Requisiciones/' . $data[0]->dependencia . '/' . substr($anio_elabora, -2) . '/' . $mes_elabora . '/' . $data[0]->no_requisicion . '/' . $data[0]->no_requisicion . '_req.pdf';

			if (file_exists($namefile) == true) {
				$adjunto = $data[0]->no_requisicion . '_req.pdf';
				//dd($adjunto);
			} else {
				$adjunto = '';
			}
			if ($data == null) {
				return redirect('/')->with('error', 'El folio no se ha encontrado.');
			}
			setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
			$qr = $data['qr'] = url('/') . '/validate_signed/' . base64_encode($folioConsulta);
			$date = Carbon::now();
			$namePathsigned = 'signed/' . $id . '/' . $id . '_' . $status_req . '.pdf';
			if (Storage::disk('local')->exists($namePathsigned)) {
				return base64_encode($namePathsigned);
			}
			$pdf = PDF::loadView('reportes.pdf.form_requisiciones_signed_autorizadf', ['data' => $data], compact('cadenaOriginal', 'folioConsulta', 'fechaFirma', 'nombreCompleto', 'sello', 'dia_elabora', 'mes_elabora', 'anio_elabora', 'dia_requiere', 'mes_requiere', 'anio_requiere', 'data2', 'puesto', 'adjunto'))->setPaper('A4', 'portrait')->setWarnings(false)->stream();
			$path = Storage::disk('local')->put($namePathsigned, $pdf);
			if ($path && Storage::disk('local')->exists($namePathsigned)) {
				$status_req = $status_req + 1;
				//dd($status_req);
				DB::table('requisiciones')->where('no_requisicion', $id)->update(['status_req' => $status_req, 'fecha_autodf' => $date, 'usr_autodf' => Auth::user()->id]);
				DB::table('sellos')->where('id_requisicion', $id)->update(['nombre_autorizadf' => $nombreCompleto,
					'puesto_autorizadf' => $puesto,
					'cadena_original_autorizadf' => $cadenaOriginal,
					'folio_consulta_autorizadf' => $folioConsulta,
					'sello_autorizadf' => $sello,
					'fecha_firma_autorizadf' => $fechaFirma,
					'status' => 1]);
				$fecha_baja_requisicion = $this->fechas_rango($fechaFirma);
				DB::table('requisiciones')->where('no_requisicion', $id)->update(['fecha_baja_requisicion' => $fecha_baja_requisicion]);
				$email = $this->email_proveedores($id);

				return base64_encode($namePathsigned);
			} else {
				return redirect('/')->with('error', 'Intenta nuevamente.');
			}
			break;

		}
	}
	public function fechas_rango($fechaFirma) {

		$range = array();
		$fecha_firma_autorizadf = $fechaFirma;
		$fecha_vencimiento_req = date("Y-m-d", strtotime("$fecha_firma_autorizadf + 7 days"));

		if (is_string($fecha_firma_autorizadf) === true) {
			$fecha_firma_autorizadf = strtotime($fecha_firma_autorizadf);
		}

		if (is_string($fecha_vencimiento_req) === true) {
			$fecha_vencimiento_req = strtotime($fecha_vencimiento_req);
		}

		if ($fecha_firma_autorizadf > $fecha_vencimiento_req) {
			return createDateRangeArray($fecha_vencimiento_req, $fecha_firma_autorizadf);
		}

		do {
			$range[] = date('Y-m-d', $fecha_firma_autorizadf);
			//dd($range);
			$fecha_firma_autorizadf = strtotime("+ 1 day", $fecha_firma_autorizadf);

		} while ($fecha_firma_autorizadf <= $fecha_vencimiento_req);

		$festivos = array(
			"1" => date('Y') . '-01-01',
			"2" => date('Y') . "-02-05",
			"3" => date('Y') . "-03-21",
			"4" => date('Y') . "-05-01",
			"5" => date('Y') . "-05-05",
			"6" => date('Y') . "-09-16",
			"7" => date('Y') . "-11-20",
			"8" => date('Y') . "-12-25",

		);

		$fecha_vencimiento_req = date("Y-m-d", $fecha_vencimiento_req);

		$fecha_firma_autorizadf = date("Y-m-d", $fecha_firma_autorizadf);

		$festivos_rango = count(array_intersect($festivos, $range));

		$fecha_vencimiento_req = date("Y-m-d", strtotime("$fecha_vencimiento_req +" . $festivos_rango . "days"));

		$dia = date("w", strtotime($fecha_vencimiento_req));

		switch ($dia) {
		case 6: //sabado
			$fecha_vencimiento_req = date("Y-m-d", strtotime("$fecha_vencimiento_req + 2 days"));
			break;
		case 0: //domingo
			$fecha_vencimiento_req = date("Y-m-d", strtotime("$fecha_vencimiento_req + 1 days"));
			break;
		}
		return $fecha_vencimiento_req;
	}
	public function getSignedPdf($path) {
		return view('view_data.get_pdf_signed', ['pdfSigned' => base64_encode(Storage::get(base64_decode($path)))]);
	}
	public function registrarCotizaciones() {
		//dd(Auth::user()->rfc);
		return view('requisiciones.registrarCotizaciones');
	}
	public function agregarCotizacion(Request $request) {
		//dd($request->id);
		$idReq = $request->id;
		$depReq = RequisicionesBienes::select('dependencia')->where('id', $idReq)->get()->toArray();
		//(dd($depReq);

		//$sesDep = Session::get('depD'); //Obtener id Dependencia
		//dd($sesDep);
		if ($request->id_folio == 0) {
			$noFol = FoliosDepen::select('folio_cot')->where('clave_num', $depReq[0]['dependencia'])
				->get()->toArray();
			//dd($noFol);
			$rfc = Auth::user()->rfc;
			$NewCotiza = new Cotizaciones;
			$NewCotiza->dependencia = $depReq[0]['dependencia'];
			$NewCotiza->folio_cot = $noFol[0]['folio_cot'] + 1;
			$NewCotiza->rfc_proveedor = $rfc;
			$NewCotiza->no_cotizacion = $request->lugar_entrega;
			//$NewCotiza->vigencia = '2019-10-01';
			//$NewCotiza->plazo_entrega =1;
			$NewCotiza->status = 1;
			$NewCotiza->save();

			$folRequest = $noFol[0]['folio_cot'] + 1;
			$folDepen = FoliosDepen::where('folio_cot', '=', $noFol[0]['folio_cot'])
				->where('clave_num', $depReq[0]['dependencia'])->first();
			//dd($folDepen);
			$noFolMas = $noFol[0]['folio_cot'] + 1;
			$folDepen->update(['folio_cot' => $noFolMas]);
		} else {
			$folRequest = $request->id_folio;
		}

		//Count si ya existe
		$count = DB::table('cotizaciones_bienes')->where('dependencia', $depReq[0]['dependencia'])
			->where('folio_cot', $folRequest)->where('id_bienreq', $idReq)->count('id');

		if ($count == 0) {
			$BienesNewsol = new CotizacionesBienes;
			$BienesNewsol->dependencia = $depReq[0]['dependencia'];
			$BienesNewsol->folio_cot = $folRequest;
			$BienesNewsol->id_bienreq = $idReq;
			$BienesNewsol->precio_unit = $request->precio_unit;
			$BienesNewsol->status = 1;
			//$BienesNewsol->unidad = $request->u_medida;
			$BienesNewsol->save();

		} else {
			$folRequest = "yaExiste";
		}
		return response()->json($folRequest);
	}
	public function getMisCotizaciones(Request $request) {
		//dd($request);
		$rfc = Auth::user()->rfc;
		$myReg = CotizacionesBienes::select('cotizaciones_bienes.id_bienreq', 'cotizaciones_bienes.folio_cot',
			'RB.no_requisicion', 'tipo_req', 'cat_cabmstotal.descripcion', 'cat_unidadalm.descripcion as descUni',
			'cantidad', 'precio_unit', 'R.fecha_requiere')
			->Join('requisiciones_bienes as RB', 'RB.id', '=', 'cotizaciones_bienes.id_bienreq')
			->Join('requisiciones as R', 'R.no_requisicion', '=', 'RB.no_requisicion')
			->join('cat_cabmstotal', 'RB.id_cabmsgrp', '=', 'cat_cabmstotal.cabms')
			->Join('cotizaciones as C', 'C.folio_cot', '=', 'cotizaciones_bienes.folio_cot')
			->Join('cat_unidadalm', 'RB.unidad', '=', 'cat_unidadalm.id')
			->where('rfc_proveedor', $rfc)
			->where('cotizaciones_bienes.folio_cot', $request->id_folio)
			->orderBy('cotizaciones_bienes.folio_cot', 'asc')
			->get()->toArray();
		return response()->json($myReg);
	}
	public function generarCotizacion($noCot) {
		//dd($noCot);
		$rfc = Auth::user()->rfc;
		$misCot = CotizacionesBienes::select('cotizaciones_bienes.id_bienreq', 'cotizaciones_bienes.folio_cot',
			'RB.no_requisicion', 'tipo_req', 'cat_cabmstotal.descripcion', 'cat_unidadalm.descripcion as descUni',
			'cantidad', 'precio_unit', 'R.fecha_requiere')
			->Join('requisiciones_bienes as RB', 'RB.id', '=', 'cotizaciones_bienes.id_bienreq')
			->Join('requisiciones as R', 'R.no_requisicion', '=', 'RB.no_requisicion')
			->join('cat_cabmstotal', 'RB.id_cabmsgrp', '=', 'cat_cabmstotal.cabms')
			->Join('cotizaciones as C', 'C.folio_cot', '=', 'cotizaciones_bienes.folio_cot')
			->Join('cat_unidadalm', 'RB.unidad', '=', 'cat_unidadalm.id')
			->where('rfc_proveedor', $rfc)
			->where('cotizaciones_bienes.folio_cot', $noCot)
			->orderBy('cotizaciones_bienes.folio_cot', 'asc')
			->get()->toArray();
		//dd($misCot);
		return view('requisiciones.generarCotizacion', ['misCot' => $misCot, 'id_folio' => $noCot]);
	}
	public function addDatosCotizacion(Request $request) {
		//dd($request);

		$id_folio = $request->id_folio;
		$no_cotizacion = $request->no_cotizacion;
		$vigencia = $request->vigencia;
		$plazo = $request->plazo_entrega;
		$garantia = $request->garantia;
		$forma_pago = $request->forma_pago;
		$representante = $request->rep_legal;
		$subtotal = $request->subtotal;
		$iva = $request->iva;
		$total = $request->total;
		//dd($total);
		$reqUp = Cotizaciones::where('folio_cot', '=', $id_folio)->first();
		$reqUp->update(['no_cotizacion' => $no_cotizacion, 'vigencia' => $vigencia, 'plazo_entrega' => $plazo,
			'garantia' => $garantia, 'forma_pago' => $forma_pago, 'repre_legal' => $representante,
			'subtotal' => $subtotal, 'iva' => $iva, 'total' => $total]);

		if ($request->hasFile('archivo')) {

			$fecha = Carbon::now();
			$m = $fecha->format('m');

			$y = $fecha->format('y');

			///dd($y);
			//dd($f2);
			//$afecha = $f2->year;

			$file = Input::file('archivo');
			$nombre = $file->getClientOriginalName();
			$request->file('archivo')->move('uploads/Cotizaciones/' . $y . '/' . $m . '/' . $id_folio, $id_folio . '_' . 'cot.pdf');

		}

		return response()->json('OK');
	}
	public function getPDFRequisicion($folioReq) {
		$reqUp = Requisiciones::where('no_requisicion', '=', $folioReq)->get()->toArray();
		//dd($reqUp[0]['created_at']);
		$fecha = Carbon::parse($reqUp[0]['created_at']);
		$mfecha = $fecha->month;
		$afecha = $fecha->year;
		$year = substr($afecha, 2, 4);
		//dd($year);
		//$str = 'abcdef';
		//dd(strlen($str));
		if (strlen($mfecha) <= 9) {
			$valor = '0';
		} else {
			$valor = '';
		}
		$files = array();
		$files2 = array();
		$dir = "uploads/Requisiciones" . "/" . $reqUp[0]['dependencia'] . '/' . $year . '/' . $valor . $mfecha . '/' . $folioReq . '/';
		//dd($dir);
		if (file_exists($dir)) {
			$directorio = opendir($dir);
			//dd($directorio);
			$i = 0;
			while ($archivo = readdir($directorio)) {
				//$var = substr($archivo,-4)==".txt";
				$files2[$i] = $archivo;
				if (substr($files2[$i], -4) == ".pdf") {
					$files[] = $archivo;
					//dd(substr($files[0],0,2));
				}
				$i++;
			} //dd($files);
		}
		return response()->json($files);
	}
	public function getPDFAdjunto($folioCot) {
		$reqUp = Cotizaciones::where('folio_cot', '=', $folioCot)->get()->toArray();
		//dd($reqUp[0]['created_at']);
		$fecha = Carbon::parse($reqUp[0]['created_at']);
		$mfecha = $fecha->month;
		$afecha = $fecha->year;
		$year = substr($afecha, 2, 4);
		//dd($year);
		$files = array();
		$files2 = array();
		if (strlen($mfecha) <= 9) {
			$valor = '0';
		} else {
			$valor = '';
		}
		$dir = "uploads/Cotizaciones" . "/" . $year . '/' . $valor . $mfecha . '/' . $folioCot . '/';
		//dd($dir);
		if (file_exists($dir)) {
			$directorio = opendir($dir);
			//dd($directorio);
			$i = 0;
			while ($archivo = readdir($directorio)) {
				//$var = substr($archivo,-4)==".txt";
				$files2[$i] = $archivo;
				if (substr($files2[$i], -4) == ".pdf") {
					$files[] = $archivo;
					//dd(substr($files[0],0,2));
				}
				$i++;
			} //dd($files);
		}
		return response()->json($files);
	}
	public function viewPdfAnexo($folioCot) {
		$reqUp = Cotizaciones::where('folio_cot', '=', $folioCot)->get()->toArray();
		//dd($reqUp[0]['created_at']);
		$fecha = Carbon::parse($reqUp[0]['created_at']);
		$mfecha = $fecha->month;
		$afecha = $fecha->year;
		$year = substr($afecha, 2, 4);
		if (strlen($mfecha) <= 9) {
			$valor = '0';
		} else {
			$valor = '';
		}
		$dir = "uploads/Cotizaciones/" . $year . "/" . $valor . $mfecha . "/" . $folioCot . '/' . $folioCot . '_cot.pdf';
		//dd($dir);
		return response()->file($dir);
		//return response ()->json($files);
	}
	public function viewPdfAnexoReq($folioCot) {
		$reqUp = Requisiciones::where('no_requisicion', '=', $folioCot)->get()->toArray();
		//dd($reqUp[0]['created_at']);
		$fecha = Carbon::parse($reqUp[0]['created_at']);
		$mfecha = $fecha->month;
		$afecha = $fecha->year;
		$year = substr($afecha, 2, 4);
		if (strlen($mfecha) <= 9) {
			$valor = '0';
		} else {
			$valor = '';
		}
		$dir = "uploads/Requisiciones/" . $reqUp[0]['dependencia'] . '/' . $year . "/" . $valor . $mfecha . "/" . $folioCot . '/' . $folioCot . '_' . 'req.pdf';
		//dd($dir);
		return response()->file($dir);
		//return response ()->json($files);
	}
	public function dataCotizacion($id_folio) {
		//dd($id_folio);
		return view('view_data.cotizacion', ['pdf' => base64_encode(Storage::get($this->generatePDFCotizacion($id_folio))), 'id' => $id_folio]);
	}
	public function generatePDFCotizacion($id) {
		//dd($id);
		$data = DB::select('select *, "cotizaciones_bienes"."id_bienreq", "cotizaciones_bienes"."folio_cot", "RB"."no_requisicion", "tipo_req", "cat_cabmstotal"."descripcion", "cat_unidadalm"."descripcion"
                  as "descUni", "cantidad", "precio_unit", "R"."fecha_requiere" from "cotizaciones_bienes"
                  inner join "requisiciones_bienes" as "RB" on "RB"."id" = "cotizaciones_bienes"."id_bienreq"
                  inner join "requisiciones" as "R" on "R"."no_requisicion" = "RB"."no_requisicion"
                  inner join "cat_cabmstotal" on "RB"."id_cabmsgrp" = "cat_cabmstotal"."cabms"
                  inner join "cotizaciones" as "C" on "C"."folio_cot" = "cotizaciones_bienes"."folio_cot"
                  inner join "cat_unidadalm" on "RB"."unidad" = "cat_unidadalm"."id"
                  where "cotizaciones_bienes"."folio_cot" =:id', ["id" => $id]);

		$fecha_requiere = $data[0]->fecha_requiere;
		$vigencia = $data[0]->vigencia;
		$plazo = $data[0]->plazo_entrega;

		$data2 = Usuarios::where('rfc', '=', $data[0]->rfc_proveedor)
			->where('nivel', '=', '3')
			->where('modulo', '=', '4')->get()->toArray();

		if ($data2 == null) {
			$data2[0] = ['nivel' => '1', 'modulo' => '1'];
		}
		if ($data == null) {
			return redirect('/')->with('error', 'La cotización no se ha encontrado.');
		}
		setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
		$date = Carbon::now();
		$fecha_requiere = strftime("%d de %B de %Y", strtotime(date($fecha_requiere)));
		$vigencia = strftime("%d de %B de %Y", strtotime(date($vigencia)));
		$plazo_entrega = strftime("%d de %B de %Y", strtotime(date($plazo)));
		$fecha = $data['date_now'] = strftime("%d de %B de %Y", strtotime(date('Y/m/d')));
		//dd($fecha);
		$namePath = 'preview/Cotizacion' . $id . '/provedor.pdf';
		if (Storage::disk('local')->exists($namePath)) {
			return $namePath;
		}
		$pdf = PDF::loadView('reportes.pdf.cotizacion', ['data' => $data], compact('fecha_requiere', 'fecha', 'vigencia', 'plazo_entrega', 'data2'))->setPaper('legal', 'portrait')->setWarnings(false)->stream();
		$path = Storage::disk('local')->put($namePath, $pdf);
		if ($path && Storage::disk('local')->exists($namePath)) {

			return $namePath;
		} else {
			return redirect('/')->with('error', 'Intenta nuevamente.');
		}
	}
	public function signedCotizacion(Request $request) {

		$collect = collect($data = DB::select('select *, "cotizaciones_bienes"."id_bienreq", "cotizaciones_bienes"."folio_cot", "RB"."no_requisicion", "tipo_req", "cat_cabmstotal"."descripcion", "cat_unidadalm"."descripcion"
            as "descUni", "cantidad", "precio_unit", "R"."fecha_requiere" from "cotizaciones_bienes"
            inner join "requisiciones_bienes" as "RB" on "RB"."id" = "cotizaciones_bienes"."id_bienreq"
            inner join "requisiciones" as "R" on "R"."no_requisicion" = "RB"."no_requisicion"
            inner join "cat_cabmstotal" on "RB"."id_cabmsgrp" = "cat_cabmstotal"."cabms"
            inner join "cotizaciones" as "C" on "C"."folio_cot" = "cotizaciones_bienes"."folio_cot"
            inner join "cat_unidadalm" on "RB"."unidad" = "cat_unidadalm"."id"
            where "cotizaciones_bienes"."folio_cot" =:id', ["id" => $request['id']]));

		$cadena_remplace = substr_replace($collect . '||', '||', 0, 0);
		$cadena_implode = implode('|', (array) $cadena_remplace);
		$cadena_comas = str_replace(',', '||', $cadena_implode);
		$cadena_original_corchete_llave_abrir = str_replace('[{', '', $cadena_comas);
		$cadena_original_corchete_llave_cerrar = str_replace('}]', '', $cadena_original_corchete_llave_abrir);
		$cadena_original = str_replace('"', '', $cadena_original_corchete_llave_cerrar);

		$tokenId = strtoupper('FPRUPRUEBA');
		$key = Session()->get('key');
		$cer = Session()->get('cer');
		$password = Session()->get('password');
		//$cadena = '||hola';
		$status_req = $request['status_req'];

		$data = "{\r\n  \"security\":\r\n  {\r\n    \"tokenId\":\"" . $tokenId . "\"\r\n  },\r\n  \"data\":\r\n  {\r\n    \"password\":\"" . base64_encode($password) . "\",\r\n    \"cadena\":\"" . $cadena_original . "\",\r\n    \"byteKey\":\"" . base64_encode($key) . "\",\r\n    \"bytecer\":\"" . base64_encode($cer) . "\"\r\n  }\r\n}";

		$curl = curl_init();

		#Los campos editables solo son: CURLOPT_PORT, CURLOPT_URL y CURLOPT_CUSTOMREQUEST.

		curl_setopt_array($curl, array(

			CURLOPT_PORT => "9005",

			CURLOPT_URL => "http://10.1.181.25/eFirma/firmaCadena",

			CURLOPT_RETURNTRANSFER => true,

			CURLOPT_ENCODING => "",

			CURLOPT_MAXREDIRS => 10,

			CURLOPT_TIMEOUT => 30,

			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

			CURLOPT_CUSTOMREQUEST => "POST",

			CURLOPT_POSTFIELDS => $data,

			CURLOPT_HTTPHEADER => array(

				"Content-Type: application/json; charset=utf-8",

				"Accept:application/json, text/javascript, */*; q=0.01"),

		));

		//dd($curl);

		#Se cacha la respuesta y el error si es que existiera en cuestiones de conectividad

		$response = curl_exec($curl);
		#El resultado lo decodifico a un Json para poder extraer los valores del arreglo
		//dd($response);
		$response = json_decode($response);
		$err = curl_error($curl);

		#Se cierra el recurso cURL y se liberan recursos del sistema.

		curl_close($curl);

		#Saco informacion del arreglo y la asigno a variables para pasarlas a la siguiente función
		$err = $response->error->code;
		$cadenaOriginal = $response->data->cadenaOriginal;
		$folioConsulta = $response->data->folioConsulta;
		$fechaFirma = $response->data->fechaFirma;
		$nombreCompleto = $response->data->nombreCompleto;
		$sello = $response->data->sello;

		#Validación de errores

		if ($err != 0) {
			return redirect()->back()->with('error', $sign['error']['msg'] . ' , verifica que tu certificado y contraseña sean validos.');
		}
		$path = $this->generatePDFfirmadoCotizacion($request->input('id'), $cadenaOriginal, $folioConsulta, $fechaFirma, $nombreCompleto, $sello, $status_req);
		//dd($path);
		return \Redirect::route('data_cotizacion_signed', $path)->with('success', 'obtenido correctamente');
	}
	public function getCotizacionSignedPdf($path) {
		//dd($path);
		return view('view_data.get_pdf_Cotizacionsigned', ['pdfSigned' => base64_encode(Storage::get(base64_decode($path)))]);
	}
	public function generatePDFfirmadoCotizacion($id, $cadena_original, $folio_consulta, $fecha_firmado, $nombre_completo, $sello) {

		$data = DB::select('select *, "cotizaciones_bienes"."id_bienreq", "cotizaciones_bienes"."folio_cot", "RB"."no_requisicion", "tipo_req", "cat_cabmstotal"."descripcion", "cat_unidadalm"."descripcion"
              as "descUni", "cantidad", "precio_unit", "R"."fecha_requiere" from "cotizaciones_bienes"
              inner join "requisiciones_bienes" as "RB" on "RB"."id" = "cotizaciones_bienes"."id_bienreq"
              inner join "requisiciones" as "R" on "R"."no_requisicion" = "RB"."no_requisicion"
              inner join "cat_cabmstotal" on "RB"."id_cabmsgrp" = "cat_cabmstotal"."cabms"
              inner join "cotizaciones" as "C" on "C"."folio_cot" = "cotizaciones_bienes"."folio_cot"
              inner join "cat_unidadalm" on "RB"."unidad" = "cat_unidadalm"."id"
              where "cotizaciones_bienes"."folio_cot" =:id', ["id" => $id]);
		//dd($folio_consulta);
		$rfc = $data[0]->rfc_proveedor;
		$vigencia = $data[0]->vigencia;
		$plazo = $data[0]->plazo_entrega;
		//dd($plazo);

		$data2 = Usuarios::where('rfc', '=', $data[0]->rfc_proveedor)
			->where('nivel', '=', '3')
			->where('modulo', '=', '4')->get()->toArray();

		if ($data2 == null) {
			$data2[0] = ['nivel' => '1', 'modulo' => '1'];
		}
		$qr = url('http://qr-folioconsulta.finanzas.cdmx.gob.mx/efirma/public/index.php') . '/validate_signed/' . base64_encode($folio_consulta);
		//dd($qr);
		if ($data == null) {
			return redirect('/')->with('error', 'La cotización no se ha encontrado.');
		}

		$qr = url('http://qr-folioconsulta.finanzas.cdmx.gob.mx/efirma/public/index.php') . '/validate_signed/' . ($folio_consulta);
		setlocale(LC_ALL, 'es_ES', 'esp_esp', 'Spanish_Spain', 'Spanish', 'es_MX.UTF-8', 'es_MX');
		$date = Carbon::now();
		$fecha = $datas['date_now'] = strftime("%d de %B de %Y", strtotime(date('Y/m/d')));
		$vigencia = strftime("%d de %B de %Y", strtotime(date($vigencia)));
		$plazo_entrega = strftime("%d de %B de %Y", strtotime(date($plazo)));
		//dd($plazo);
		$namePathsigned = 'signed/Cotizacion' . $id . '/provedor.pdf';
		if (Storage::disk('local')->exists($namePathsigned)) {
			return base64_encode($namePathsigned);
		}
		$pdf = PDF::loadView('reportes.pdf.cotizacion_signed', ['data' => $data], compact('id', 'fecha', 'cadena_original', 'folio_consulta', 'fecha_firmado', 'nombre_completo', 'sello', 'qr', 'vigencia', 'plazo_entrega', 'data2'))->setPaper('legal', 'portrait')->setWarnings(false)->stream();
		$path = Storage::disk('local')->put($namePathsigned, $pdf);
		if ($path && Storage::disk('local')->exists($namePathsigned)) {
			DB::table('cotizaciones')->where(['folio_cot' => $id])->update(['cadena_original' => base64_encode($cadena_original), 'folio_consulta' => $folio_consulta, 'fecha_firma' => $fecha_firmado, 'nombre' => $nombre_completo, 'sello' => base64_encode($sello)]);
			return base64_encode($namePathsigned);
		} else {
			return redirect('/')->with('error', 'Intenta nuevamente.');
		}
	}
	public function getParPreTotal(Request $request) {
		if ($request->tipo_req == 1) {
			$bienes1 = '2';
			$bienes2 = '5';
		} elseif ($request->tipo_req == 2) {
			$bienes1 = '1';
			$bienes2 = '3';
		} elseif ($request->tipo_req == 3) {
			$bienes1 = '3';
			$bienes2 = '0';
		}

		$par_preTot = ParPreTotal::select('par_pre', 'descripcion')
		//->whereRaw('capitulo',[$bienes1])
			->whereIn('capitulo', [$bienes1, $bienes2])
			->orderBy('descripcion', 'asc')->get()->toArray();
		//dd($par_preTot);
		return response()->json($par_preTot);
	}
	public function getCabmsTotal(Request $request) {

		$cabmsGRP = CambsTotal::select('cabms', 'descripcion')
			->where('par_pre', $request->par_pre)
		//->whereIn('capitulo', [$bienes1, $bienes2])
			->orderBy('descripcion', 'asc')->get()->toArray();

		return response()->json($cabmsGRP);
	}
	public function getDetalleExistencia($noReq) {
		$detalle = DB::select('select RB.id_cabmsgrp, CASE WHEN SUM(existencia) IS NULL THEN 0 ELSE SUM(existencia) END AS suma
             from requisiciones_bienes RB
             inner join cat_cabmsgrp on RB.id_cabmsgrp =  cat_cabmsgrp.cabms
             left outer join existencias  on cat_cabmsgrp.clave_grp = existencias.id_cabmsgrp
             where no_requisicion = ' . $noReq . '  group by  RB.id_cabmsgrp
             order by RB.id_cabmsgrp desc');

		$subDetalle = DB::select('select RB.id_cabmsgrp,cat_cabmsgrp.clave_grp, descripcion, sum(existencia)
              from requisiciones_bienes RB
              inner join cat_cabmsgrp on RB.id_cabmsgrp =  cat_cabmsgrp.cabms
              right outer join existencias  on cat_cabmsgrp.clave_grp = existencias.id_cabmsgrp
              where no_requisicion = ' . $noReq .
			'  group by descripcion, RB.id_cabmsgrp, cat_cabmsgrp.clave_grp order by cat_cabmsgrp.clave_grp, cat_cabmsgrp.clave_grp desc');
		return response()->json(["detalle" => $detalle, "subDetalle" => $subDetalle]);
	}
	public function guardarCargo(Request $request) {
		//dd($request->input());
		$count = DB::table('formatos_usuarios')->where('rfc', $request['rfc'])->count('id');
		//dd($count);
		if ($count != 1) {
			$usuario = DB::table('formatos_usuarios')->insert([
				'dependencia' => $request['dependencia'],
				'id_area_enlace' => $request['area'],
				'id_formato' => '3',
				'recibe_envia' => '3',
				'nombre' => $request['nombre'],
				'puesto' => $request['puesto'],
				'rfc' => $request['rfc'],
				'status' => true,

			]);
			return redirect('/home');
		}
	}
	public function rechazar(Request $request) {

		return view('layouts/rechazado', ['id' => $request['id'], 'status_req' => $request['status_req'], 'tipo' => $request['tipo']]);
	}
	public function saverechazado(Request $request) {

		if ($request['tipo'] == 'TR') {
			$rechazado = DB::table('requisiciones')
				->where('no_requisicion', $request['id'])
				->update(['status' => false, 'status_req' => '5', 'motivo' => strtoupper($request['motivo'])]);
			return redirect('/requisiciones/reqTramitar');
		}

		if ($request['tipo'] == 'RM') {
			$rechazado = DB::table('requisiciones')
				->where('no_requisicion', $request['id'])
				->update(['status' => false, 'status_req' => '6', 'motivo' => strtoupper($request['motivo'])]);
			return redirect('/requisiciones/reqAutorizaRM');
		}
		if ($request['tipo'] == 'DF') {
			$rechazado = DB::table('requisiciones')
				->where('no_requisicion', $request['id'])
				->update(['status' => false, 'status_req' => '7', 'motivo' => strtoupper($request['motivo'])]);
			return redirect('/requisiciones/reqAutorizaDGA');
		}
	}
	public function selected(Request $request) {
		$data = $request->except('_token', 'status_req', 'tipo');
		//dd($data);
		if ($data == NULL) {
			return redirect()->back()->with('error', 'No selecciono ningun registro para firmar.');
		}
		$status_req = $request->status_req;
		$tipo = $request->tipo;

		//dd($data);
		$this->signedmasive($data, $status_req, $tipo);
		return redirect()->back()->with('msg', 'Requisiciones firmadas exitosamente!!!');
	}
	public function signedmasive($data, $status_req, $tipo) {

		//dd($data, $status_req, $tipo);

		/**********************      S Q L    P A R A    T R A E R    I D E N T I F I C A D O R E S      ********************/

		$array_id = DB::select('select * ,cat_par_pre.descripcion as par_des
                                           ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion
                                           from requisiciones as r
         inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
         inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
         left join cat_par_pre as cat_par_pre on cat_par_pre.par_pre = r.par_pre
         inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
         where status_req =:status_req', ["status_req" => $status_req]);
		//dd($array_id);

		if (empty($array_id)) {
			return redirect()->back()->with('error', 'No hay requisiciones que firmar!!!');
		} else {

			foreach ($data as $value) {
				$array = $value;
			}

			for ($i = 0; $i < sizeof($array); $i++) {
				$id = $array[$i];

				$collect = collect($data = DB::select('select * ,cat_par_pre.descripcion as par_des
                                           ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion
                                           from requisiciones as r
         inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
    inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
    left join cat_par_pre as cat_par_pre on cat_par_pre.par_pre = r.par_pre
    inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
            and r.no_requisicion =:id', ["id" => $id]));
				$cadena_remplace = substr_replace($collect . '||', '||', 0, 0);

				$cadena_implode = implode('|', (array) $cadena_remplace);

				$cadena_comas = str_replace(',', '||', $cadena_implode);
				$cadena_original_corchete_llave_abrir = str_replace('[{', '', $cadena_comas);
				$cadena_original_corchete_llave_cerrar = str_replace('}]', '', $cadena_original_corchete_llave_abrir);
				$cadena_original = str_replace('"', '', $cadena_original_corchete_llave_cerrar);
				$cadena_original = base64_encode($cadena_original);

				$tokenId = strtoupper('FPRUPRUEBA');
				$key = Session()->get('key');
				$cer = Session()->get('cer');
				$password = Session()->get('password');
				//$cadena = '||hola';
				//$status_req = $request['status_req'];
				//$tipo = $request['tipo'];

				$data = "{\r\n  \"security\":\r\n  {\r\n    \"tokenId\":\"" . $tokenId . "\"\r\n  },\r\n  \"data\":\r\n  {\r\n    \"password\":\"" . base64_encode($password) . "\",\r\n    \"cadena\":\"" . $cadena_original . "\",\r\n    \"byteKey\":\"" . base64_encode($key) . "\",\r\n    \"bytecer\":\"" . base64_encode($cer) . "\"\r\n  }\r\n}";

				$curl = curl_init();

				#Los campos editables solo son: CURLOPT_PORT, CURLOPT_URL y CURLOPT_CUSTOMREQUEST.

				curl_setopt_array($curl, array(

					CURLOPT_PORT => "9005",

					CURLOPT_URL => "http://10.1.181.25/eFirma/firmaCadena",

					CURLOPT_RETURNTRANSFER => true,

					CURLOPT_ENCODING => "",

					CURLOPT_MAXREDIRS => 10,

					CURLOPT_TIMEOUT => 30,

					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

					CURLOPT_CUSTOMREQUEST => "POST",

					CURLOPT_POSTFIELDS => $data,

					CURLOPT_HTTPHEADER => array(

						"Content-Type: application/json; charset=utf-8",

						"Accept:application/json, text/javascript, */*; q=0.01"),

				));

				//dd($curl);

				#Se cacha la respuesta y el error si es que existiera en cuestiones de conectividad

				$response = curl_exec($curl);
				#El resultado lo decodifico a un Json para poder extraer los valores del arreglo

				$response = json_decode($response);

				$err = curl_error($curl);

				#Se cierra el recurso cURL y se liberan recursos del sistema.

				curl_close($curl);

				#Saco informacion del arreglo y la asigno a variables para pasarlas a la siguiente función
				$err = $response->error->code;
				$cadenaOriginal = $response->data->cadenaOriginal;
				$folioConsulta = $response->data->folioConsulta;
				$fechaFirma = $response->data->fechaFirma;
				$nombreCompleto = $response->data->nombreCompleto;
				$sello = $response->data->sello;

				#Validación de errores

				if ($err != 0) {
					return redirect()->back()->with('error', $sign['error']['msg'] . ' , verifica que tu certificado y contraseña sean validos.');
				}

				$path = $this->generatePDFfirmado($id, $cadenaOriginal, $folioConsulta, $fechaFirma, $nombreCompleto, $sello, $status_req, $tipo);
			}
			//return redirect()->back()->with('msg', 'Requisiciones firmadas exitosamente!!!');

		}
	}
	public function email_proveedores($id) {

		$requisicion = DB::select('select * ,cat_unidadalm.descripcion as uni_des
                                           ,ct.descripcion as ct_descripcion,
                                           cat_parpretotal.descripcion as par_descripcion
                                           from requisiciones as r
                                           inner join requisiciones_bienes as rb  on rb.no_requisicion = r.no_requisicion
                                           inner join cat_cabmstotal as ct on rb.id_cabmsgrp = ct.cabms
                                           left join cat_parpretotal as cat_parpretotal on cat_parpretotal.par_pre = r.par_pre
                                           inner join cat_unidadalm as cat_unidadalm on rb.unidad = cat_unidadalm.id
                                           and r.no_requisicion =:id', ["id" => $id]);
		//dd($requisicion);
		$proveedores = CatProveedores::select('nombre', 'email')->where('email', '!=', 'NULL')->orderBy('id', 'asc')->get()->toArray();

		foreach ($proveedores as $value) {

			$data = array(
				'name' => $value['nombre'],
			);
			$email = $value['email'];

			$subject = "Liberación de Requisición No. " . $id;
			Mail::send('emails.welcome', compact('data', 'requisicion'), function ($message) use ($subject, $email) {
				$message->from('requisiciones@finanzas.cdmx.gob.mx', 'Gobierno de la Ciudad de México');
				$message->to($email);
				$message->subject($subject);

			});

		}
	}

 

  // FORMULARIO DE PRUPUESTA - ANEXO TÉCNICO DE BIENES
  public function formAnexo() 
  {
		return view('requisiciones.formAnexo');
	}
}
