<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rotina extends Model
{
    protected $table = 'rotinas';

    protected $fillable = [
        'sigla',
        'nome',
        'aitvo',
        'sigla_modulo',
        'sigla_sistema',
    ];
}
