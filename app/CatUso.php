<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatUso extends Model
{
    protected $table = 'cat_uso';

    protected $fillable = [
        'id', 'descripcion', 'status', 'created_at','updated_at'
    ];
}
