<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'modules';
    
    protected $primaryKey = 'id'; 

    public function modulos()
    {
        return $this->hasMany(Modulo::class, 'sigla_sistema', 'sistema');
    }
}
