<?php

namespace App\Livewire\TI\Missoes;

use App\Models\TI;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MissoesEncerradas extends Component
{
    public $missoesEncerradasPU = [];
    public $mEPU = 0;
    public $missoesEnc = false;

    public function loadMissoesEnc()
    {
        $email = Auth::user()->email;

        $this->missoesEncerradasPU = TI::where('dn_solvers_users','like','%'.$email.'%')
            ->where('dn_date', '>', now()->subDays(30))
            ->where(function ($query) {
                $query->where('closedate', '<>', null)
                    ->orWhereIn('status', [5,6,7,8,9]);
            })
            ->where('is_deleted', 0)
        ->get();

        $this->mEPU = TI::where('dn_solvers_users','like','%'.$email.'%')
            ->where('dn_date', '>', now()->subDays(30))
            ->where(function ($query) {
                $query->where('closedate', '<>', null)
                    ->orWhereIn('status', [5,6,7,8,9]);
            })
        ->count();

        $this->missoesEnc = true;        
    }

    public function render()
    {
        return <<<'HTML'
        <div class="card-body table-responsive px-4 py-4 col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="card-title">Missões encerradas ( {{$mEPU}} )</h3>
            </div>
            <hr>
            @if(!$missoesEnc)
                <div wire:init="loadMissoesEnc" class="p-10 text-center text-gray-500">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p>Gerando relatório, aguarde...</p>
                </div>
            @else
                <table class="table table-hover">
                    <thead>
                        <th>Chamado</th>
                        <th>Solicitante</th>
                        <th>Descrição</th>
                        <th>Árvore</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                        @if($mEPU != 0 )
                            @foreach ($missoesEncerradasPU as $missao)
                                <tr>
                                    <td>
                                        @if(ctype_digit($missao->id ))
                                            <a href="https://helpdesk.pacaembuautopecas.com.br/front/ticket.form.php?id={{$missao->id }}" 
                                                    target="blank"
                                                    class="links">
                                                    {{ $missao->id }}
                                            </a>
                                        @else
                                            {{ $missao->id }}
                                        @endif
                                    </td>
                                    <td>{{ $missao['dn_requesters_users'][0]['fullname']}}</td>
                                    <td>{{ Str::limit( strip_tags(html_entity_decode($missao['content'], ENT_QUOTES, 'UTF-8')), 100, ' [...]') }}</td>
                                    <td>{{ $missao['dn_category_name']}}</td>
                                    <td>
                                        <a href="{{ route('missoes.show', $missao->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="3">
                                    Não á missões encerradas para exibir.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @endif
        </div>
        HTML;
    }
}
