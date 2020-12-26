<?php

namespace App\Http\Controllers\Auth;


use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Mail\EmailConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($data)
    {
        echo $data;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request
     * @return App\Models\Usuarios\Users;
     */
    protected function create(Request $request)
    {
        $datos = User::validaCorreo($request->remail);
        //dd(22);
        if ($datos == null) {
            \Log::info(__METHOD__ . ' Crear nuevo Usuario');
            try {
                //dd(33);
                $confirmation_code = str_random(25);
                //$url_confirmation = env('APP_URL') . "register/verify/" . $confirmation_code;
                $usuario = $request->nombre." ".$request->apaterno;
                $user = User::create([
                   
                    'name' => $request->name,
                    'apellido_paterno' => $request->name,
                    'apellido_materno' => $request->name,
                    'usuario' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'estatus' => (!$request->estatus_user) ? '0' : '1',
                    'confirmation_code' => $confirmation_code
                ]);
                //dd(55);
                ////Mail::to($request->remail)->send(new EmailConfirmation($url_confirmation, $usuario));
                //$respuesta = array('resp' => true, 'mensaje' => 'El usuario se Registro y se envio el correo');
                $respuesta =array('resp' => true, 'mensaje' => 'El usuario se Registro');
                //se agina el rol "sin asignar"
                $grol = DB::table('roles')->where('id', '=',1 )->first();
               // Le asignamos el rol
               $user->assignRole($grol->name);
                DB::commit();
                return $respuesta;
           } catch (\Exception $th) {
                DB::rollback();
                dd($th->getMessage());
                \Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
                $respuesta = ['resp' => false, 'message' => 'Error al guardar el usuario.'];
                return $respuesta;
            }
        } else {
            $respuesta = array('resp' => false, 'mensaje' => 'El correo ya esta registrado');
            return $respuesta;
        }
    }
    /**
     * Validate User Email registration.
     *
     * @param Request
     * @return json
     */
    public function validemail(Request $request)
    {
        $email =  $request->remail;
        $datos = User::validaCorreo($email);
        if ($datos == null) {
            \Log::info(__METHOD__ . ' valida existencia de email');
            try {
                return response()->json(['status' => 'valido'], 200);
            } catch (\Exception $th) {
                return response()->json(['status' => 'error al consultar'], 200);
            }
        } else {
            return response()->json(['status' => 'ya existe el correo'], 200);;
        }
    }

    /**
     * Validate User registration in BD.
     *
     * @param Request
     * @return json
     */

    public function validUser(Request $request)
    {
        $user =  $request->user;
        $datos = User::validUser($user);
        if ($datos == null) {
            \Log::info(__METHOD__ . ' valida existencia de usuario');
            try {
                return response()->json(['status' => 'valido'], 200);
            } catch (\Exception $th) {
                return response()->json(['status' => 'error al consultar'], 200);
            }
        }else{
            return response()->json(['status' => 'no_valido'], 200);
        }
    }
}
