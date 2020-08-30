<?php

namespace App\Models\Usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersMonitoring extends Model
{

    protected $table = 'users_monitorings';
    protected $fillable = [
        'id_users',
        'token',
        'login',
        'intentos',
    ];
    /**
     * Get the user token to reset password.
     *
     * @param  $token
     * @return $user
     */
    public static function getDatosToken($request)
    {
        $token = $request;
        $user = DB::table('users_monitorings')->where('token', '=', $token)->first();
        return $user;
    }
    public static function getDatosUserId($request)
    {
        $id = $request;
        $user = DB::table('users_monitorings')->where('id_users', '=', $id)->first();
        return $user;
    }
}
