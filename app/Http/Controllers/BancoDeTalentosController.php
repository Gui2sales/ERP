<?php

namespace App\Http\Controllers;

use App\Models\BancoTalentos;
use App\Models\Documentos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BancoDeTalentosController extends Controller
{
    public function index(Request $request){

        $candidatos = BancoTalentos::select()
        ->leftJoin('users','users.id','=','banco_talentos.recrutador')
        ->get();

        $usuario=Auth::id();

        return view('Dho.BancoDeTalentos.index',compact('candidatos','usuario'));
    }

    public function create()
    {
        return view('Dho.BancoDeTalentos.create');
    }

    public function store(Request $request)
    {
        $arquivo_nome = "N/A";
        $flag_sigilo = false;

        if($request->file('documento')){
            $path = $request->file('documento')->store('documentos', 'public');
            $arquivo_nome = "Curriculo" . $request->cpf;

            Documentos::create([
                'titulo' => $arquivo_nome,
                'descricao' => "curriculo do talento " . $request->nome,
                'tela' => 'BancoDeTalentos',
                'arquivo_path' => $path,
            ]);
        }
        
        if ($request->sigilosa == 1){
            $flag_sigilo = true;
        }

        $talento =  DB::table('banco_talentos')->insert([
            'nome' => $request->nome ,
            'cpf' => $request->cpf ,
            'numero' => $request->numero ,
            'email' => $request->email ,
            'linkedin' => $request->linkedin ,
            'nascimento' => $request->nascimento ,
            'uf' => $request->uf ,
            'estado' => $request->estado ,
            'cidade' => $request->cidade ,
            'endereco' => $request->endereco ,
            'municipio' => $request->municipio ,
            'cep' => $request->cep ,
            'cargo_de_interesse' => $request->cargo_de_interesse ,
            'experiencia1' => $request->experiencia1 ,
            'experiencia2' => $request->experiencia2 ,
            'emprego_atual' => $request->emprego_atual ,
            'formacao1' => $request->formacao1 ,
            'formacao2' => $request->formacao2 ,
            'formacao3' => $request->formacao3 ,
            'obs' => $request->observacao ,
            'nota_entrevista' => $request->entrevista ,
            'recrutador' => Auth::id() ,
            'origem_capitacao' => $request->capitacao ,
            'documentos' => $arquivo_nome ,
            'flag_sigilo' => $flag_sigilo ,
            'fase_processo' => $request->processo ,

        ]);

        if($talento){
            return redirect()->route('Banco de Talentos')->with('success','Talento registrado com sucesso.');
        }else{
            return redirect()->route('Banco de Talentos')->with('error','Erro ao registrar talento. Por favor, tente novamente.');
        }
    }

    public function show(Request $request, $id)
    {
        $candidato = BancoTalentos::select()->where('id', $id)->get()->first();
        $recrutador = User::select('name')->where('id',$candidato->recrutador)->get()->first();

        return view('Dho.BancoDeTalentos.show',compact('candidato', 'recrutador'));
    }
}
