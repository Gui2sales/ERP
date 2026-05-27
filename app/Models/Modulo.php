<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';

    protected $fillable = [
        'sigla',
        'nome',
        'aitvo',
        'sigla_sistema'
    ];

    public function modules()
    {
        return $this->hasMany(Modules::class, 'sistema', 'sigla_sistema');
    }
}
