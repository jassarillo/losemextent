<?php

namespace App\Models\Catalogos;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CatProveedores extends Model
{
    //
    protected $table = 'cat_proveedores';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nombre_proveedor', 'rfc', 'dom_fiscal', 'telefono', 'giro', 'tipo_proveedor'];

    public static function nombreProv($dato1)
    {
        $datos = DB::table('cat_proveedores')
        ->select('nombre_proveedor')
        ->where('id',$dato1)->first();
        return $datos;
    }
}


