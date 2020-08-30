<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ModelHasRole extends Model
{
    protected $table = 'model_has_roles';
    protected $primaryKey = 'role_id';
    public $timestamps = false; // Deshabilita update_at

    protected $fillable = [
        'model_type',
        'model_id',
    ];
    public static function getMRol($id_rol)
    {
        $idUsuarioRol = DB::table('rol')->where('model_id', '=', $id_rol)->get();
        return $idUsuarioRol;
    }
}

