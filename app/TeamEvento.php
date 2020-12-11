<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamEvento extends Model
{
    protected $table = 'team_evento';

    protected $fillable = [
        'id','id_evento','id_empleado','status','created_at','updated_at'
    ];
}
