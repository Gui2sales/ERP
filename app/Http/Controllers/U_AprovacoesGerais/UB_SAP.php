<?php

namespace App\Http\Controllers\U_AprovacoesGerais;

use App\Http\Controllers\Controller;

class UB_SAP extends Controller
{
    public function index()
    {        
        return view('U_AprovacoesGerais.UB_SAP.main');
    }
    
    public function ubd()
    {
        return view('U_AprovacoesGerais.UB_SAP.ubd');
    }
    public function aprovacao($numero,$rota,$sequencia)
    {
        return view('U_AprovacoesGerais.UB_SAP.ubd_aprovaSAP',compact('numero','rota','sequencia'));
    }
}
