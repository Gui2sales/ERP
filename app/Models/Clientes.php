<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'cadastro_clientes';

    protected $fillable = [
        'id',
        'codigo',
        'razsoc',
        'endereco',
        'bairro',
        'municipio',
        'estado',
        'cep',
        'ativ_num',
        'ativ_desc',
        'ra_cic',
        'insc_est',
        'repres_cod',
        'repres_desc',
        'filial_cli',
        'filial_nome',
        'sit_num',
        'sit_desc',
    ];
}
