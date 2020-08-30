<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Models\Usuarios\UsersMonitoring as UsersM;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Mail\PassForgot;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $confirmation_pass = str_random(25);
        $url_confirmation = env('APP_URL') . "public/forgot/verify/" . $confirmation_pass;
        $datos = User::validaCorreo($request->email);
        if ($datos == null) {
            $respuesta = array('resp' => false, 'mensaje' => 'El correono existe');
            return $respuesta;
        }
        else {
            \Log::info(__METHOD__ . 'El correo si existe');
            try {
               $id_user=$datos->id;
               $token_forgot = str_random(25);
               $url_confirmation = env('APP_URL') . "public/forgot/verify/" . $token_forgot;
                $datosMoni = UsersM::create([
                'id_users' => $id_user,
                'token' =>$token_forgot,
                ]);
                DB::commit();
               // Mail::to('eortega@finanzas.cdmx.gob.mx')->send(new PassForgot($url_confirmation));
                Mail::to($request->email)->send(new PassForgot($url_confirmation));
                $respuesta = array('resp' => true, 'mensaje' => 'Enviado Correctamente');
                return $respuesta;
             } catch (\Exception $th) {
                DB::rollback();
               $respuesta = ['resp' => false, 'message' => 'Error al enviar el correo.'];
               return $respuesta;
            }
        }
    }
    protected function validateTokenPassReset($request)
    {
        $datos = UsersM::getDatosToken($request);

        if($datos == null){
            $respuesta = array('resp' => false, 'mensaje' => 'El token ah expirado');
            return redirect('/login');

        }else{
            \Log::info(__METHOD__ . 'Actualiza el usuario');
        try {
            $id=$datos->id_users;
            //dd($id);
            $datosU = User::find($id);
            $respuesta = array('resp' => true, 'mensaje' => 'token validado');
            return view('usuarios/passReset')->with('datosU', $datosU);
        } catch (\Exception $th) {
            return response()->json(['status'=>'error','message'=>'Error  al  actualizar'],200);
        }
        }

    }
    public function updatePass(Request $request)
    {
        $new_pass = $request->input('new_password');
        $usuario = $request->input('usuario');
        $datos = User::getDatosUser($usuario);
        $id=$datos->id;
        $datosUsuario = User::find($id);
        $password = Hash::make($new_pass);
        $datosUsuario->password = $password;
        $monitorinUser = UsersM::getDatosUserId($id);
        $monitorinUserID=   $monitorinUser->id;
        $monitorin = UsersM::find($monitorinUserID);
        \Log::info(__METHOD__ . 'Actualiza el usuario');
        try {
        $monitorin->token = null;
        $monitorin->valid_password = false;
        $datosUsuario->save();
        $monitorin->save();
        return response()->json(['status'=>'success','message'=>'Contraseña actualizado correctamente'],200);
        } catch (\Exception $th) {
            DB::rollback();
            \Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            return response()->json(['status'=>'error','message'=>'Error  al  actualizar'],200);
        }
    }

    protected function sendResetLinkResponse($response)
    {
        if (request()->header('Content-Type') == 'application/json') {
            return response()->json(['success' => 'Recovery email sent.']);
        }
        return back()->with('status', trans($response));
    }
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if (request()->header('Content-Type') == 'application/json') {
            return response()->json(['error' => 'Oops something went wrong.']);
        }
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }
}
