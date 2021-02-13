<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailr extends Model
{
    protected $fillable = ['id',  'attachment', 'email', 'subject', 'message'];
}
