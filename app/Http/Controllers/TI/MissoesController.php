<?php

namespace App\Http\Controllers\TI;

use App\Http\Controllers\Controller;
use App\Models\TI;
use App\Services\GlpiService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MissoesController extends Controller
{
    public function index()
    {   
        return view('TI.Missoes.index');
    }
    
    public function show(Request $request, $id)
    {        
        $chamado = TI::select()
        ->where('id',$id)
        ->first();

        $usuario = $chamado->dn_solvers_users[0]['fullname'];

        if ($chamado->status = 1) { $status = "Novo"; }
        elseif($chamado->status = 2) { $status = "Em Atendimento"; }
        elseif($chamado->status = 3) { $status = "Transferência"; }
        elseif($chamado->status = 4) { $status = "Pendente"; }
        elseif($chamado->status = 5) { $status = "Solucionado"; }
        elseif($chamado->status = 6) { $status = "Fechado"; }

        if ($chamado->urgency = 1) { $prioridade = "Super Emergêncial";}
        elseif($chamado->urgency = 2) { $prioridade = "Emergêncial";}
        elseif($chamado->urgency = 3) { $prioridade = "Urgente";}
        elseif($chamado->urgency = 4) { $prioridade = "Normal";}
        elseif($chamado->urgency = 5) { $prioridade = "Baixa";}
        elseif($chamado->urgency = 6) { $prioridade = "Baixíssima";}
        elseif($chamado->urgency = 7) { $prioridade = "Sem Prioridade";}

        $tipo = $chamado->dn_category_name;

        return view('TI.Missoes.show', compact('chamado', 'usuario', 'status', 'prioridade', 'tipo'));
    }

    public function destroy($chamado, $usuario, $ordem) : RedirectResponse
    {
        $tempo = Carbon::now('America/Sao_Paulo')->toDateTimeString();

        if($ordem == 1)
        {
            $check= DB::table('time_track_missoes')
            ->select('id')
            ->where('usuario_id', $usuario)
            ->where('stop', null)
            ->where('start', '<>', null)
            ->first();

            if($check)
            {
                DB::table('time_track_missoes')
                ->where('id', $check->id)
                ->update([
                    'stop' => $tempo,
                ]);
            }

            $consultaAcesso= DB::table('time_track_missoes')
            ->select('id', 'acesso')
            ->where('chamado_id', $chamado)
            ->where('usuario_id', $usuario)
            ->where('stop', '<>', null)
            ->orderByDesc('acesso')
            ->first();

            if($consultaAcesso)
            {
                DB::table('time_track_missoes')
                ->where('chamado_id', $chamado)
                ->where('usuario_id', $usuario)
                ->insert([
                    'chamado_id' => $chamado,
                    'usuario_id' => $usuario,
                    'start' => $tempo,
                    'acesso' => $consultaAcesso->acesso + 1
                ]);
            }
            else 
            {
                DB::table('time_track_missoes')
                ->where('chamado_id', $chamado)
                ->where('usuario_id', $usuario)
                ->insert([
                    'chamado_id' => $chamado,
                    'usuario_id' => $usuario,
                    'start' => $tempo,
                    'acesso' => 1
                ]);
            }
        }

        if($ordem == 0)
        {
            DB::table('time_track_missoes')
            ->where('chamado_id', $chamado)
            ->where('usuario_id', $usuario)
            ->update([
                'stop' => $tempo,
            ]);
        }

        return redirect()->route('missoes');
    }

    public function encerra(Request $request, GlpiService $glpi, $chamado, $colaborador)
    {
        $tempo = Carbon::now('America/Sao_Paulo')->toDateTimeString();

        $encerraChamado = $glpi->closeTicket($chamado, $request->descricao);

        $checkStop = DB::table('time_track_missoes')
            ->select('id')
            ->where('chamado_id', $request->chamado)
            ->where('usuario_id', $request->colaborador)
            ->where('stop', '=', null)
        ->first();

        if ($checkStop){            
            DB::table('time_track_missoes')
            ->where('id', $checkStop->id)
            ->update([
                'stop' => $tempo,
            ]);
        }

        if($encerraChamado){
            return redirect()->route('missoes')->with('success','Chamado '. $request->chamado . ' encerrado!');
        }else{
            return redirect()->route('missoes')->with('error','Erro ao encerrar o chamado. Por favor, tente novamente ou vá até o GLPI.');
        }
    }
}