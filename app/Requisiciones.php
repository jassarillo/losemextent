<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisiciones extends Model
{
    protected $table = 'requisiciones_new';

    protected $fillable = [

          'id', 'dependencia', 'tipo_req', 'no_requisicion', 'fecha_elabora', 'fecha_requiere', 'lugar_entrega','observaciones', 'clave_progpresu', 'monto_estim', 'par_pre', 
          'usr_solicita', 'usr_tramita', 'fecha_tramita', 'usr_autorm', 'fecha_autorm', 'usr_autodf', 'fecha_autodf', 'status_req', 'status', 'monto_estimado','adjunto','updated_at', 'created_at'
    ];
}