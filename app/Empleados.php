<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'id','nro_empleado','nombre_completo','status','created_at','updated_at'
    ];
}
