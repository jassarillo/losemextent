<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class CatUnidadMedida extends Model
{
    //
    protected $table = 'cat_unidad_medidas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'descripcion',
        'activo',
    ];
}

