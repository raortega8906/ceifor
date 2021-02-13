<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table= 'events';

    //
    protected $fillable = [
        'titulo', 'descripcion', 'color', 'fecha',
    ];

    public $timestamps = false;
}
