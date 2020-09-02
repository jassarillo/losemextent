<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\ModelHasRole;
use App\Models\Licitaciones;
use App\Models\Subasta;
use App\Models\Catalogos\CatProveedores;
use App\Models\ProveedorUsuario;
use App\Http\Requests\UserRequest;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\PropuestaEconomica;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $datos = User::where('id', auth()->user()->id)->get();
        return view('usuarios.perfil', compact('datos'));
    }

    public function dashboard()
    {
          
       $perfil = Auth::user()->hasAnyRole(['SuperAdmin', 'Admin']);
       //dd($perfil);
       if($perfil == true){
          //dd(33);  
        return view('admin.dashboard');
        }else{
            //dd(9999);
           //return view('/home');
            return view('admin.dashboard');
       }
    }

    public function create() {
        $roles = DB::table('roles')->get();
        return view('modals/users/add_user')->with('roles', $roles);
    }

    public function create_rol()
    {
        return view('modals.roles.add_new_role');
    }

    public function store_new_role(Request $request) {
        \Log::info(__METHOD__.' Crear nuevo Rol');
        $existeRol = Role::where('name','=',$request->rol)->get();
        if(!empty($existeRol)){
            try {
                    $rol = $request->rol;
                    DB::beginTransaction();
                    $new_rol = Role::create([
                            'name' => $rol,
                            'guard_name' => 'web'
                        ]);
                    $response = array('success' => true, 'message' => 'Rol creado correctamente.');
                    DB::commit();
                } catch (\Exception $th) {
                \Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
                DB::rollback();
                    $response = ['success' => false, 'message' => 'Error al guardar el usuario.'];
                }
            }else{
                $response = ['success' => false, 'message' => 'Ya existe ese rol.'];
            }
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\usuarios\Users  $users
     * @return \Illuminate\Http\Response
    */
    public function edit(Request $request){
        $id = $request->id;
        $datosRoles = User::getRol($id);
        $roles = DB::table('roles')->get();
        $user = User::find($id);
        return view('modals/users/edit_user')
            ->with(compact('user'))
            ->with(compact('datosRoles'))
            ->with(compact('roles'));
    }

    public function editar_roles_permisos(Request $request){
       $id=$request->id;
       $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('admin.roles.editar_roles_permisos', compact('role', 'permissions'));
    }

    public function store(Request $request){
        \Log::info(__METHOD__.' Crear nuevo Usuario');
        try {
            $id_rol = $request->id_rol;
            DB::beginTransaction();
            $user = User::create([
                    'name' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'usuario' => $request->usuario,
                    'id_rol' => $id_rol,
                    'password' => bcrypt($request->password),
                    'email' => $request->email,
                    'estatus' => ($request->estatus_user == "on" ) ? 1 : 0,
                    'rfc' => $request->rfc
                ]);
            $grol = DB::table('roles')->where('id', '=', $id_rol)->first();
            // Le asignamos el rol
            $user->assignRole($grol->name);
            if($grol->id == 5){
            $user->givePermissionTo('proveedor');
            }else{
            $user->givePermissionTo('Ver');
            }
            $response = array('success' => true, 'message' => 'Usuario creado correctamente.');
            DB::commit();
        } catch (\Exception $th) {
            \Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            DB::rollback();
            $response = ['success' => false, 'message' => 'Error al guardar el usuario.'];
        }
        return $response;
    }

    /**
     * Actualizar usuario.
     *
     * @param  Request  $request
     * @param  Users  $users
     * @return Response
     */
    public function update(Request $request, User $users){
        \Log::info(__METHOD__);
        try {
            $id = $request->id_usuario;
            $id_rol = $request->id_rol;
            $estatus = ($request->estatus_user == "on" ) ? 1 : 0;
            //Obtenemos el usuario
            $users = User::findOrFail($id);
            //Asignamos los valoes a actualizar
            $users->name = $request->nombres;
            $users->apellido_paterno = $request->apellido_paterno;
            $users->apellido_materno = $request->apellido_materno;
            $users->email = $request->correo;
            $users->estatus = $estatus;
            $users->id_rol = $id_rol;
            $users->rfc = $request->rfc;
            // Actualización de password
            if ($request->filled('password') && $request->filled('password2') ) {
                $password = $request->password;
                $pass2 = $request->password2;
                if ($password == $pass2) {
                    $password = Hash::make($password);
                    $users->password = $password;
                }
            }
            $users->save();
            $idUsuarioRol = DB::table('model_has_roles')->where('model_id', '=', $id)->first();
            $idUsuarioRolAnterior = $idUsuarioRol->role_id;

            ModelHasRole::where('model_id', $id)
               ->where('role_id', $idUsuarioRolAnterior)
               ->update(['role_id' => $id_rol]);
            $response = ['success' => true, 'message' => 'Usuario actualizado satisfactoriamente.'];
        } catch (\Exception $th) {
            \Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            $response = ['success' => false, 'message' => 'Error al actaulizar el usuario.'];
        }
        return $response;
    }

    public function listar_usuarios(){
        return view('usuarios.listar_usuarios');
    }

    public function data_listar_usuarios(){
        $users = User::all();
        return Datatables::of($users)->toJson();
    }

    public function listar_roles(){
        $roles = Role::all();//Get all roles
        //return view('roles.index')->with('roles', $roles);
    return view('admin.roles.listar_roles')->with('roles', $roles);
    }

    public function data_listar_roles(){
        $role = Role::all();//Get all roles
        //  $permisos = =Permissions::getAllPermisos()
        //$role->permissions()->pluck('name');
        return Datatables::of($role)->toJson();
    }

    public function listar_permisos(){   
        $permisos = Permission::all();
        return view('admin.permisos.listar_permisos', compact('permisos'));
    }

    public function create_permiso(){
        //$datos = Role::all();
        return view('modals.permisos.add_new_permiso');
    }

    public function store_new_permiso(Request $request) {
        \Log::info(__METHOD__.' Crear nuevo permiso');
        $existePermiso = Permission::where('name','=',$request->rol)->get();
        if(!empty($existePermiso)){
            try {
                  $rol = $request->rol;
                   DB::beginTransaction();
                    $new_rol = Permission::create([
                            'name' => $rol,
                            'guard_name' => 'web'
                        ]);
                    $response = array('success' => true, 'message' => 'Permiso creado correctamente.');
                    DB::commit();
                } catch (\Exception $th) {
                \Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
                DB::rollback();
                    $response = ['success' => false, 'message' => 'Error al guardar el permiso.'];
                }
        }else{
            $response = ['success' => false, 'message' => 'Ya existe ese permiso.'];
        }
        return $response;
    }

    public function data_listar_permisos(){
        return Datatables::of(Permissions::getAllPermisos())
            ->toJson();
        //return view('usuarios.listar_usuarios', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, $id){

        $role = Role::findOrFail($id);//Get role with the given id
        //Validate name and permission fields
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
             'Role'. $role->name.' updated!');
    }
}