<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bienes extends Model
{
    protected $table = 'bienes';

    protected $fillable = [
        'id', 'id_seccion', 'descripcion', 'status', 'created_at','updated_at'
    ];
}
