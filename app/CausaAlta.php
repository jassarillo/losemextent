<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CausaAlta extends Model
{
    protected $table = 'cat_altas';

    protected $fillable = [
        'id', 'descripcion', 'status', 'created_at','updated_at'
    ];
}
