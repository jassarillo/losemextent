<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medidas extends Model
{
    protected $table = 'cat_medidas';

    protected $fillable = [
        'id','descripcion','status'
    ];
}
