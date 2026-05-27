<?php

namespace App\Http\Controllers\V_Suprimento;

use App\Http\Controllers\Controller;

class VC_Cotacao extends Controller
{
    public function index()
    {        
        return view('Suprimentos.Cotacao.AprovaCotacao.index');
    }

    public function show($filial, $cotacao)
    {        
        return view('Suprimentos.Cotacao.AprovaCotacao.showcotacao',compact('filial','cotacao'));
    }
    
}
