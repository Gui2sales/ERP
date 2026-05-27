<?php

namespace App\Livewire\Administracao;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UsuarioEdita extends Component
{
    public string $usu;
    public $exibeUsu = false;
    public $usuario;
    public $perfis;
    public $permissoes;
    public $notifica = false;
    public $perfilSelecionado = "";
    public array $inlineCheckbox = [];
    
    public function toggleExibe($acao)
    {
        if($acao == 'true'){
            $this->buscaUsu();
            $this->exibeUsu = true;
        }
        else{
            $this->notifica = true;
            $this->exibeUsu = false;
        }        
    }

    protected function buscaUsu()
    {
        $id = $this->usu;
        $this->usuario = User::where('id', $id)->first();

        $this->perfis = DB::table('roles')
            ->select(
                'roles.id', 
                'roles.name',
                DB::raw('MAX(users.id) as usu_id')
            )
            ->leftJoin('model_has_roles', 'model_has_roles.role_id', '=','roles.id')
            ->leftJoin('users', function ($join) use ($id){
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('users.id', '=', $id);
            })
            ->where('roles.ativo',1)
            ->groupBy('roles.id','roles.name')
            ->orderByRaw("CASE WHEN MAX(users.id) IS NOT NULL AND MAX(users.id) = ? THEN 0 ELSE 1 END", [$id])
            ->distinct()
            ->get();

        $this->permissoes = DB::table('permissions')
            ->select('permissions.id','permissions.name', 'model_id')
            ->leftJoin('modules as m',"m.id","permissions.modulo_id")
            ->leftJoin('model_has_permissions', function ($join) use ($id){
                $join->on('model_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('model_has_permissions.model_id', '=', $id);
            })
            ->orderBy('id')
            ->distinct()
            ->get();

        $this->inlineCheckbox = $this->permissoes
            ->where('model_id', $id)
            ->pluck('name')
            ->toArray();
    }

    public function editaUsuario()
    {
        $usuario = $this->usuario;
        if($this->perfilSelecionado){
            $usuario->syncRoles($this->perfilSelecionado);
        }

        $usuario->syncPermissions($this->inlineCheckbox);
        
        $this->dispatch('refresh');
        $this->dispatch('notificacao', msg: 'Usuário Alterado!');
        $this->toggleExibe('false');
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="btn btn-primary btn-sm" wire:click="toggleExibe('true')"><i class="bi bi-pencil"></i></div>
            @if($exibeUsu)
                <div class="fundo_modal">
                    <div class="card_modal w-100 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="card-title">Edição de Usuário</h3>
                            <button class="btn btn-secondary" wire:click="toggleExibe('false')"><i class="bi bi-x"></i></button>
                        </div>
                        <form class="container-fluid" wire:submit.prevent='editaUsuario'>
                            <div class="row">
                                <div class="d-flex col-6 mb-3">
                                    <div class="col-2 div_nome">Nome</div>
                                    <input type="text" class="div_campo col-10" id="name" name="name" value="{{ $usuario->name }}" required>
                                </div>
                                <div class="d-flex col-6 mb-3">
                                    <div class="col-2 div_nome">Email</div>
                                    <input type="email" class="div_campo col-10" id="email" name="email" value="{{ $usuario->email }}" required>
                                </div>
                                <div class="d-flex col-4 mb-3">
                                    <label for="role_id" class="form-label col-2">Perfil</label>
                                    <select name="role_id" id="role_id" class="form-select col" wire:model='perfilSelecionado'>
                                        @foreach($perfis as $perfil)
                                            <option value="{{ $perfil->name }}">
                                                {{ $perfil->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row p-2 caixa">
                                @foreach($permissoes as $permissao)
                                    <div class="form-check col-2">
                                        <input type="checkbox" 
                                            class="form-check-input"  
                                            id="perm_{{ $permissao->id }}" 
                                            name="inlineCheckbox" 
                                            value="{{ $permissao->name }}"
                                            wire:model='inlineCheckbox'
                                        >
                                        <label class="form-check-label" for="perm_{{ $permissao->id }}">{{ $permissao->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Salvar </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            @if($notifica)
                <livewire:Components.BoxNotificacao lazy :titulo='"Edita Usuário"' :key='$usu'/>
            @endif
        </div>
        HTML;
    }
}
