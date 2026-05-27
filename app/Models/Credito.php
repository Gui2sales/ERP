<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $table = 'modulo_financeiro_credito_main';

    protected $fillable = [
        'id',
        'data_entrada',
        'filial',
        'codigo',
        'nf_devolucao',
        'nf_venda',
        'valor_devolucao',
        'sod_num',
        'sustado',
        'observacao',
        'status',
    ];
}
