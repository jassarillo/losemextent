<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    protected $fillable = [
        'id', 'id_clasifica', 'id_bien', 'fecha_inventario','motivo_alta','factura','precio','conteo',
        'progresivo','unico','id_evento','status','created_at','updated_at'
    ];
}
