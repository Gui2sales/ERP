<?php

namespace App\Http\Controllers\TI;

use App\Http\Controllers\Controller;
use App\Models\Areas;
use App\Models\Missoes;
use App\Models\TI;
use App\Models\User;
use App\Services\GlpiService;
use App\Services\TimeDiff;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GestaoTiController extends Controller
{
    public function index(Request $request, GlpiService $glpi, TimeDiff $timeDiff)
    {
        $emAberto = TI::where('closedate', null)
            ->whereNotIn('status', [6,7,8,9])
            ->where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
            ->where('is_deleted', 0)
            ->count(); 

        $encerradas = TI::where('dn_date', '>', now()->subDays(30))
            ->where(function ($query) {
                $query->where('closedate', '<>', null)
                    ->orWhereIn('status', [6,7,8,9]);
            })
            ->where('dn_entity_completename','LIKE','Pacaembu > TI > Sistemas%')
            ->where('is_deleted', 0)
            ->count(); 

        $porColaborador = Missoes::select(
                DB::raw('COUNT(CASE WHEN missoes.encerramento IS NOT NULL THEN 1 END) as encerradas'),
                DB::raw('COUNT(CASE WHEN missoes.encerramento IS NULL THEN 1 END) as abertas'),
                'colaborador',
                'users.name'
            )
            ->leftJoin('users','users.id','=','missoes.colaborador')
            ->groupBy('colaborador', 'users.name')
            ->where(function ($query) {
                $query->where('encerramento', null)
                    ->orWhere('encerramento', '>', now()->subDays(30));
            })
            ->get();

        $chamados = TI::select('id','dn_solvers_users')
            ->where('dn_observers_users','LIKE', '%cesar.gaspar@pabu.com.br%')
            ->where('dn_solvers_users', 'LIKE', '[]')
            ->whereNotIn('status',[5,6])
            ->where('is_deleted', 0)
            ->count();

        $missoes = TI::select()
            ->where('dn_observers_users', 'LIKE', '%cesar.gaspar@pabu.com.br%')
            ->where('dn_solvers_users', 'LIKE', '[]')
            ->whereNotIn('status',[5,6])
            ->where('is_deleted', 0)
            ->paginate(15);
        
        return view('TI.Gestao.index', compact('emAberto'
        , 'encerradas', 'porColaborador', 'chamados', 'missoes'
        ));
    }

    public function create()
    {
        $usuarios = User::where('email','LIKE','ti0%')
        ->where('ativo',1)
        ->orderBy('name')
        ->get();

        $areas = Areas::where('ativa',1)->get();

        return view('TI.Gestao.create',compact('usuarios','areas'));
    }

    public function store(Request $request, GlpiService $glpi)
    {
        $hoje = time();
        $dataConvertida = date('Y-m-d', $hoje);

        $getEmail = User::select('email')->where('id', $request->colaborador)->first();
        $email = $getEmail['email'];

        if (!$getEmail) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $getUsuario = DB::table('glpi_prod.glpi_useremails')
        ->select('users_id')
        ->where('email', $email)
        ->first();
        $usuario = $getUsuario->users_id;
        
        if (!$getUsuario) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
        
        $criaChamado = $glpi->createTicketWithObservers([
            'name'    => $request->titulo,
            'content' => $request->descricao,
            'entities_id' => 2,
            'type' => 1,
            'urgency' => 3,
            'impact' => 3,
            '_users_id_requester' => 1631,
        ], [163]);

        $glpi->assignSolver($criaChamado['id'], $usuario);

        DB::table('time_track_missoes')
        ->insert([
            'chamado_id' => $criaChamado['id'],
            'usuario_id' => $request->colaborador,
            'acesso' => 1,
        ]);

        if ($criaChamado['id'])
        {
            Missoes::create([
                'chamado' => $criaChamado['id'] ,
                'solicitante' => 'Cesar Augusto Gaspar' ,
                'descricao' => $request->descricao ,
                'sistema' => $request->sistema ,
                'status' => $request->status ,
                'tipo' => $request->tipo ,
                'prioridade' => $request->prioridade ,
                'colaborador' => $request->colaborador ,
                'area' => $request->area ,
                'abertura' => $dataConvertida ,
                'vencimento' => $request->vencimento ,
            ]);
        }
        
        if($criaChamado['id']){
            return redirect()->route('gestao')->with('success','Chamado '. $criaChamado['id'] . ' registrado com sucesso.');
        }else{
            return redirect()->route('gestao')->with('error','Erro ao registrar missão. Por favor, tente novamente.');
        }
    }

    public function update(Request $request, $id, GlpiService $glpi)
    {
        $getEmail = User::select('email')->where('id', $request->colaborador)->first();
        $email = $getEmail['email'];

        if (!$getEmail) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $getUsuario = DB::table('glpi_prod.glpi_useremails')
        ->select('users_id')
        ->where('email', $email)
        ->first();
        $usuario = $getUsuario->users_id;
        
        if (!$getUsuario) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $glpi->assignSolver($id, $usuario);

        if($glpi){
            return redirect()->route('gestao')->with('success','Missão atribuída com sucesso.');
        }
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

        return view('TI.Gestao.show', compact('chamado', 'usuario', 'status', 'prioridade', 'tipo'));
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

        return redirect()->route('gestao');
    }

    public function encerra(Request $request, GlpiService $glpi, $chamado, $colaborador)
    {
        $hoje = time();
        $dataConvertida = date('Y-m-d', $hoje);
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
            return redirect()->route('gestao')->with('success','Chamado '. $request->chamado . ' encerrado!');
        }else{
            return redirect()->route('gestao')->with('error','Erro ao encerrar o chamado. Por favor, tente novamente ou vá até o GLPI.');
        }
    }
}