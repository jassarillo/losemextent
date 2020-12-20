<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bienes extends Model
{
    protected $table = 'bienes';

    protected $fillable = [
        'id','id_clasificacion','descripcion','observacion','causa_alta','fecha_alta','estado','largo','largo_medida','ancho','ancho_medida','alto','alto_medida','diametro','diametro_medida','peso','peso_medida','calibre','calibre_medida','volumen','volumen_medida','uso_material','status','created_at','updated_at'
    ];
}
