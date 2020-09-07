<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secciones extends Model
{
    protected $table = 'secciones';

    protected $fillable = [
        'id', 'id_seccion','par_pre','descripcion', 'status', 'created_at','updated_at'
    ];
}
