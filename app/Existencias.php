<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Existencias extends Model
{
    protected $table = 'existencias';

    protected $fillable = [
        'id', 'bodega', 'cabm_articulo', 'id_clasifica', 'id_bien', 
        'conteo_existencia', 'status', 'created_at', 'updated_at'
    ];
}
