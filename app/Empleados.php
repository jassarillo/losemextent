<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'id','nro_empleado','nombre_completo','status',
        'direccion','telefono','email','edad','created_at','updated_at'
    ];
}
