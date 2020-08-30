<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacenes extends Model
{
    protected $table = 'cat_almacenes';

    protected $fillable = [
        'id', 'dependencia', 'clave_alm', 'tipo', 'unidad_admva', 'dir_gral', 'jefe_alm', 'responsable', 'tel', 'calle', 'colonia', 'alcaldia', 'cp',
              'ciudad', 'centro_gestor', 'mts_cuadra', 'observac'
    ];
}
