<?php

namespace App\Livewire\Administracao;

use App\Models\Modulo;
use App\Models\Rotina;
use App\Models\Sistema;
use App\Services\NewOpusSocketService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Menus extends Component
{
    public $modulos;
    public $timestamp;
    protected $cacheKey;
    public bool $exibe = false;
    public bool $bloqueiaBotao = true;

    public string $nome;
    public string $icone;
    public string $sistema;
    public $status = 1;
    public $menu;

    public function mount()
    {
        $this->buscaTimestamp();
        $this->statusBotao();
    }

    protected function statusBotao()
    {
        if(($this->timestamp + 300) > time()){
            $this->bloqueiaBotao = true;
        }
        else{
            $this->bloqueiaBotao = false;
        }
    }

    protected function buscaTimestamp()
    {
        $this->cacheKey = "opus.smr";
        $this->timestamp = DB::table('cache')->select('expiration')->where('key', '=', $this->cacheKey)->first();
        if($this->timestamp){
            $this->timestamp = $this->timestamp->expiration - 18000;
        }
        else {
            $this->timestamp = time() - 1000;
        }

        $this->dispatch('timestamp-changed', $this->timestamp);
    }

    public function atualizaSMR(NewOpusSocketService $opus)
    {
        $this->statusBotao();

        if($this->bloqueiaBotao == false)
        {
            Cache::forget("opus.smr");
            
            $dados = $opus->getSMR('','','')['sistema'];
            
            foreach ($dados as $dado)
            {
                Sistema::updateOrCreate(
                    [
                        'sigla' => $dado['sisID'],
                        'nome' => $dado['sisNOME'],
                    ]
                );

                Modulo::updateOrCreate(
                    [
                        'sigla' => $dado['modID'],
                        'nome' => $dado['modNOME'],
                        'sigla_sistema' => $dado['sisID'],
                    ]
                );

                Rotina::updateOrCreate(
                    [
                        'sigla' => $dado['rotID'],
                        'nome' => $dado['rotNOME'],
                        'sigla_sistema' => $dado['sisID'],
                        'sigla_modulo' => $dado['rotID'],
                    ]
                );
            }

            $this->buscaTimestamp();
            $this->statusBotao();
        }
    }

    public function toggleExibe()
    {
        $this->nome = "";
        $this->icone = "";
        $this->sistema = "";

        $this->exibe = !$this->exibe;
    }

    public function updatedSistema()
    {
        $this->menu = Sistema::where('sigla', '=', $this->sistema)->get()->first();
        if($this->menu){
            $this->nome = $this->menu['nome'];
        }
        
    }

    public function criaMenu()
    {
        $modulo =  DB::table('modules')->insert([
            'nome' => mb_strtolower($this->nome),
            'icone' => $this->icone,
            'descricao' => $this->nome,
            'status' => $this->status,
            'sistema' => $this->sistema,
            'ativo' => 1,
        ]);

        $id_modulo = DB::getPdo()->lastInsertId();
        
        Permission::firstOrCreate(['name' => mb_strtolower($this->nome), 'modulo_id' => $id_modulo, 'tela_id' => 0, 'funcao' => '']);
        DB::table('busca_telas_index')->insert([
            'NOME_EXIBIDO' => mb_strtolower($this->nome),
            'NOME' => $this->icone,
            'ROTA' => $this->nome,
            'SIGLA' => mb_strtoupper($this->sistema, 'UTF-8'),
            'ATIVO' => 0,
        ]);

        if($modulo){
            return redirect()->route('menus')->with('success','Menu criado com sucesso.');
        }else{
            return redirect()->route('menus')->with('error','Erro ao registrar menu. Por favor, tente novamente.');
        }
    }

    public function render()
    {
        $this->modulos = DB::table('modules')->get();

        return view("Livewire.Administracao.menus");
    }
}
