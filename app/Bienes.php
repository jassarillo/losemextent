<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bienes extends Model
{
    protected $table = 'bienes';

    protected $fillable = [
        'id', 'id_clasificacion', 'descripcion', 'causa_alta', 'fecha_alta', 'estado', 'largo', 'ancho', 'alto', 
        'diametro', 'peso', 'uso_material', 'status', 'created_at','updated_at'
    ];
}
