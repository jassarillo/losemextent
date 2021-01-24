<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponsableEvento extends Model
{
    protected $table = 'responsable_evento';

    protected $fillable = [
        'id','id_evento','id_empleado','status','created_at','updated_at'
    ];
}
