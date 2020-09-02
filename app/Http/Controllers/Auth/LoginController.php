<?php namespace App\Http\Controllers\Auth;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo='/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function login() {
        
      
        $datos=request();
        $usuario=$datos['username'];
        $validator=Auth::attempt(['usuario'=> $datos['username'], 'password'=> $datos['password'], 'estatus'=> '1']);

        if($validator==true) {
            $datosUsuario=DB::table('users')->where('usuario', '=', $usuario)->first();
            $id=$datosUsuario->id;
            $modelHasRol=DB::table('model_has_roles')->where('model_id', '=', $id)->first();
         
                $response=['success'=>true,'admin'=>true];
           ///dd($id);
                //$depSS = $Usuario[0]['dependencia'];
                Session::put('idUserSes', $id);
                $sesDep = Session::get('idUserSes');
                //dd($sesDep);
            return $response;
        }

        else {
            $response=['success'=>false];
        }


    }

    public function logout(Request $request) {
        session()->flush();
        return redirect('/login');
    }

    public function verify($code) {
        $user=User::where('confirmation_code', $code)->first();

        if ( ! $user) return redirect('/')->with('notification', 'El link ha caducado');
        $user->confirmed=true;
        $user->confirmation_code=null;
        $user->estatus=1;
        $user->id_rol=3;
        $user->save();
        return redirect('/home')->with('notification', 'Has confirmado correctamente tu correo!');
    }

}