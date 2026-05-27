<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    protected $fillable = ['titulo', 'descricao', 'arquivo_path', 'tela'];
}
