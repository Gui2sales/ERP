<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Missoes extends Model
{
    protected $fillable = [
        'chamado',
        'solicitante',
        'descricao',
        'sistema',
        'status',
        'tipo',
        'prioridade',
        'colaborador',
        'area',
        'abertura',
        'vencimento',
    ];
}
