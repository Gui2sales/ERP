<?php

namespace App\Livewire\Administracao;

use App\Models\User;
use App\Services\NewOpusSocketService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Usuarios extends Component
{
    public $perfis;
    public $permissoes;
    public $usuarios;
    public $retorno;
    
    public bool $notifica = false;
    public bool $exibe = false;
    public bool $toggleBotao = true;
    public string $nome;
    public string $email;
    public string $usuario = "";
    public string $msg = "";
    public string $perfilSelecionado = "";
    public array $inlineCheckbox = [];

    public $filtroAtivo = "1";
    public $filtroNome = "";
    public $filtroEmail = "";
    public $filtroUsuario = "";

    public $orderBy = 'users.name';
    
    public function updated()
    {
        $this->usuarios = User::select(
            'users.id as cod_usu',
            'users.name as nome_usu',
            'users.user as usuario',
            'users.email',
            'users.ativo',
            'roles.name as nome_role'
        )
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->whereLike('users.ativo',"%{$this->filtroAtivo}%")
        ->whereRaw("UPPER(users.name) LIKE UPPER('%".$this->filtroNome."%')")
        ->whereRaw("UPPER(users.email) LIKE UPPER('%".$this->filtroEmail."%')")
        ->whereLike('users.user',"{$this->filtroUsuario}%")
        ->orderBy('users.name')
        ->get();
    }

    public function toggleExibe()
    {
        $this->nome = "";
        $this->email = "";
        $this->usuario = "";
        $this->toggleBotao = true;

        $this->exibe = !$this->exibe;
    }

    public function updatingUsuario()
    {
        $this->toggleBotao = true;
    }

    public function criaUsuario()
    {
        $validaUsuario = User::where('user', $this->usuario)->first();
        if($validaUsuario){
            $this->notifica = true;
            return $this->dispatch('notificacao', msg: 'Usuário ja cadastrado!');
        }

        if($this->usuario == "" || $this->nome == "" || $this->email == "" || $this->perfilSelecionado == "")
        {
            $this->notifica = true;
            return $this->dispatch('notificacao', msg: 'É necessário que todos os campos estejam preenchidos!');
        }

        User::create([
            'name' => $this->nome,
            'email' => $this->email,
            'user' => $this->usuario,
            'ativo' => 1,
        ]); 
        
        $user = User::where('user',$this->usuario)->first();

        $user->syncRoles($this->perfilSelecionado);
        $user->syncPermissions($this->inlineCheckbox);
        $this->notifica = true;
        $this->msg = "Usuário" . $this->usuario . " criado com sucesso!";

        $this->dispatch('notificacao', msg: '$this->msg');
        $this->dispatch('refresh');
        $this->toggleExibe();
    }

    #[On('refresh')]
    public function buscaUsuario(NewOpusSocketService $opus)
    {
        $validaUsuario = User::where('user', $this->usuario)->first();
        if($validaUsuario){
            $this->notifica = true;
            return $this->dispatch('notificacao', msg: 'Usuário ja cadastrado!');
        }

        if($this->usuario == "")
        {
            $this->notifica = true;
            return $this->dispatch('notificacao', msg: 'Preencha o campo Usuário!');
        }

        $buscaOpus = $opus->getUsuarios($this->usuario);
        
        if(!isset($buscaOpus['user'][0]))
        {
            $this->notifica = true;;
            return $this->dispatch('notificacao', msg: 'Usuário não encontrado!');
        }

        $this->retorno = $buscaOpus['user'][0];

        if($this->retorno['nome'] <> "" && $this->retorno['email'] <> ""){
            $this->nome = $this->retorno['nome'];
            $this->email = $this->retorno['email'];
            $this->toggleBotao = false;
        }
    }

    public function order($campo)
    {
        
    }
    
    public function render()
    {
        $this->updated();
        $this->perfis = DB::table('roles')->where('ativo',1)->orderBy('id')->distinct()->get();
        $this->permissoes = DB::table('permissions')->orderBy('id')->distinct()->get();

        return view('Livewire.Administracao.usuarios');
    }
}
