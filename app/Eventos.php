<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'id','destino','fecha','hora','entregado','descripcion','lugar',
        'status','empleado1','empleado2','empleado3','created_at','updated_at'
    ];
}
