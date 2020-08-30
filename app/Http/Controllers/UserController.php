<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
use Session;

class UserController extends Controller {

    public function __construct() {
        $this->middleware(['auth']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function profile() {
        //Get all users and pass it to the view
        $datos = User::where('id', auth()->user()->id)->get();   
        return view('usuarios.perfil', compact('datos'));        
    }
    public function forgotpass() {
        //Get all users and pass it to the view
           $datos = User::where('id', auth()->user()->id)->get();
           return view('usuarios.passforgot', compact('datos'));
        }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
    //Get all roles and pass it to the view
            $roles = DB::table('roles')->get();
            return view('modals/users/add_user')->with('roles', $roles);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
        return redirect('users');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request) {
        $id=$request->id;
        $user = User::findOrFail($id); //trae el usuario con el id solicitado
        $roles = Role::get(); //trae todos los roles
        return view('users.edit', compact('user', 'roles')); //pasa los usuarios, roles a la vista

    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        $user = User::findOrFail($id); //Get role specified by id

    //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required|min:6|confirmed'
        ]);
        $input = $request->only(['name', 'email', 'password']); //Retreive the name, email and password fields
        $roles = $request['roles']; //Retreive all roles
        $user->fill($input)->save();

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        return redirect()->route('users.index')
            ->with('flash_message',
             'User successfully edited.');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id) {
    //Find a user with a given id and delete
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message',
             'User successfully deleted.');
    }

    /**
    * Funciones de Actualizar Usuarios
    *
    *
    */
    public function listar_usuarios()
    {
        return view('usuarios.listar_usuarios');
    }

    public function data_listar_usuarios()
    {
        $users = User::select();
        return Datatables::of( $users )->toJson();
    }

    public function updatePassword(Request $request)
    {
        $pass_actual = $request->input('password_actual');
        $new_pass = $request->input('new_password');

        $usuario = User::find(auth()->user()->id);
        $usuario->password = Hash::make($new_pass);

        $usuario->save();

        if($usuario){
            return response()->json(['status'=>'success','message'=>'Contraseña actualizado correctamente'],200);
        }
        return response()->json(['status'=>'error','message'=>'Error  al  actualizar'],200);
    }

    public function validPassword(Request $request){

       $hashedPassword = User::find(auth()->user()->id)->password;

        if (Hash::check($request->input('password_actual'), $hashedPassword)){
            return response()->json(['status'=>'valido'],200);
        }

        return response()->json(['status'=>'no_valido'],200);
    }

    public function editUser(Request $request){

        $usuario = User::find(auth()->user()->id);

        $usuario->name = $request->input('name');
        $usuario->apellido_paterno = $request->input('apellido_paterno');
        $usuario->apellido_materno = $request->input('apellido_materno');

        $usuario->save();

        if($usuario){
            //echo $request->file;
            $file = $request->file;
            $avatar =  $usuario->avatar;

            if ($request->hasFile('file')) {
                $estado = $request->file->store('avatares');

                if($estado){
                    $this->destroyAvatar($avatar);

                    $usuario->avatar = $estado;
                    $usuario->save();

                    return response()->json(['status' => 'success','avatar' => $estado, 'message' => 'Perfil  actualizado correctamente'],200);
                }
            }
            return response()->json(['status'=>'success','avatar' => $avatar,'message'=>'Perfil  actualizado correctamenteee'],200);
        }
        return response()->json(['status'=>'error','message'=>'Error  al  actualizar datos de Perfil'],200);
    }

    public function destroyAvatar($route_avatar){
        if($route_avatar!='avatares/avatar_neutro.jpeg'){
            Storage::delete($route_avatar);
        }
    }

}
