<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable = [
        'path',
        'ip',
        'request',
        'result',
        'error',
    ];
}
