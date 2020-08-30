<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table = 'cat_unidadalm';

    protected $fillable = [
        'id','descripcion', 'status', 'updated_at', 'created_at'
    ];
}
