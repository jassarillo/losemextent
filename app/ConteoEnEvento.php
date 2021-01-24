<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConteoEnEvento extends Model
{
    protected $table = 'conteo_en_evento';

    protected $fillable = [
        'id','id_clasifica', 'id_bien', 'conteo_evento', 'id_inventario','conteo_regreso',
        'unico','id_evento','observaciones','estado_fisico', 'status','created_at','updated_at'
    ];
}
