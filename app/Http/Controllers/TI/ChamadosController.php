<?php

namespace App\Http\Controllers\TI;

use App\Http\Controllers\Controller;
use App\Models\TI;
use Illuminate\Http\Request;

class ChamadosController extends Controller
{
    public function index(Request $request)
    {
        $limitesPermitidos = [10, 20, 30];
        $limite = $request->input('limite', 15);

        if (!in_array($limite, $limitesPermitidos)) {
            $limite = 15; 
        }

        $hoje = time();
        $seis_meses_atras = strtotime('-1 months', $hoje);
        $data_formatada = date('Y-m-d', $seis_meses_atras);

        $diaDe = date('d', $seis_meses_atras);
        $mesDe = date('m', $seis_meses_atras);
        $anoDe = date('y', $seis_meses_atras);
        $diaAte = date('d', $hoje);
        $mesAte = date('m', $hoje);
        $anoAte = date('y', $hoje);


        $ti = TI::where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
        ->where('dn_date','>',$data_formatada)
        ->where('status',1)
        ->where('is_deleted',0)
        ->orderBy('id','desc')
        ->paginate(
            $perPage = $limite, $columns = ['*'], $pageName = 'page'
        );


        $novos = TI::where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
        ->where('status',1)
        ->where('is_deleted',0)
        ->count(); 

        $abertoSistemas = TI::where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
        ->where('dn_date','>',$data_formatada)
        ->where('is_deleted',0)
        ->count(); 

        $emAbertoSistemas = TI::where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
        ->whereNotIn('status',[7,5,6])
        ->where('is_deleted',0)
        ->count(); 

        $fechadoSistemas = TI::where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
        ->where('dn_date','>',$data_formatada)
        ->whereNotIn('status',[1,2,3,4])
        ->where('is_deleted',0)
        ->count(); 



        return view('TI.Chamados.index',
            compact('ti','limite','limitesPermitidos','abertoSistemas','emAbertoSistemas','fechadoSistemas','novos',
            'diaDe', 'mesDe', 'anoDe', 'diaAte', 'mesAte', 'anoAte'));
    }
}
