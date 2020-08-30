<?php
namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword;



class User extends Authenticatable
{
     use HasRoles;
     use Notifiable;
    protected $guard_name = 'web';
    protected $fillable =  ['name','apellido_paterno','apellido_materno','email','password','estatus','id_rol','usuario','confirmation_code','remember_token','rfc'];

    //Trae los usuarios generales de la BD
    public static function getusuario($request)
    {
      $users = DB::table('users')->where('id','=','$id')->first();
      return $users;
    }
      /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
  ];

  public function sendPasswordResetNotification($token)
  {
      $this->notify(new ResetPassword($token));
  }

  //trae el rol del usuario
  public static function getRol($request)
    {
      $datosRol = DB::table('model_has_roles')->where('model_id','=',$request)->first();
            $idModelRol=$datosRol->role_id;
            $intModelRol = (int)$idModelRol;
            $datosRoles = DB::table('roles')->where('id','=',$intModelRol)->first();
            $nombreRol= $datosRoles->name;
      return $datosRoles;


    }
    public static function role_permissions($id_user) {
        $role_has_permissions=DB::table('role_has_permissions')->where('role_id', '=',$id_user)->first();
    return $role_has_permissions;

    }
    public static function permission_name($id_permiso) {
     $permission_name=DB::table('permissions')->where('id','=', $id_permiso)->first();
    return $permission_name;
    }
    /**
     * Validate if email exist.
     *
     * @param  $usuario
     * @return  all user data
     */
    public static function getDatosUser($request)
    {
        $user = $request;
        $user = DB::table('users')->where('usuario', '=', $user)->first();
        return $user;
    }
    /**
     * Validate if email exist.
     *
     * @param  $request
     * @return
     */

    public static function validaCorreo($request)
    {
      $email=$request;
      $datosCorreo = DB::table('users')->where('email','=',$request)->first();
      return $datosCorreo;
    }

    /**
     * Validate if user registration exist.
     *
     * @param  $request
     * @return
     */

    public static function validUser($request)
    {
      $user=$request;
      $user = DB::table('users')->where('usuario','=',$user)->first();
      return $user;
    }
     /**
     * Return Ubicacion
     *
     * @param  $request
     * @return
     */
    public static function getProveedores()
    {
      //$user=$request;
      $data = DB::table('users')
      ->select('proveedor_usuario.id_usuario','proveedor_usuario.id_proveedor','cat_proveedores.nombre_proveedor','users.usuario',DB::raw('COUNT(propuesta_economicas.id_licitacion) as total'))
      ->leftjoin('proveedor_usuario','proveedor_usuario.id_usuario','=','users.id')
      ->leftjoin('cat_proveedores','proveedor_usuario.id_proveedor','=','cat_proveedores.id')
      ->leftjoin('propuesta_economicas','proveedor_usuario.id_proveedor','=','propuesta_economicas.id_proveedor')
      ->groupby('proveedor_usuario.id_usuario','proveedor_usuario.id_proveedor','cat_proveedores.nombre_proveedor','users.usuario');
      return $data;
    }
    public static function getUsuarioProveedores()
    {
      //$user=$request;
      $data = DB::table('users')
      ->select('id','id_usuario','id_proveedor','users.name','users.usuario','users.apellido_materno')
      ->leftjoin('proveedor_usuario','proveedor_usuario.id_usuario','=','users.id');
      return $data;
    }
    public static function getProveedoresUsuario()
    {
      //$user=$request;
      $data = DB::table('cat_proveedores')
      ->select('cat_proveedores.nombre_proveedor','cat_proveedores.id','proveedor_usuario.id_proveedor')
      ->leftjoin('proveedor_usuario','proveedor_usuario.id_proveedor','=','cat_proveedores.id');
      return $data;
    }


}

