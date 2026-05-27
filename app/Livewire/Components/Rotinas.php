<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Rotinas extends Component
{
    public string $modulo;
    public bool $exibe = false;
    public Array $telas;
    public $moduloAtual;

    public function toggleExibe()
    {
        $this->exibe = !$this->exibe; 

        if($this->exibe)
        {
            $this->buscaTelas();
        }
    }

    public function buscaTelas()
    {
        $this->telas = DB::table('busca_telas_index')
            ->whereRaw("SIGLA LIKE UPPER('".$this->modulo."%')")
            ->where('ATIVO','=','1')
            ->whereNot('SIGLA',$this->modulo)
            ->get()
            ->toArray();
    }
    
    public function render()
    {
        $this->moduloAtual = DB::table('busca_telas_index')
            ->select('NOME')
            ->where('ATIVO','=','1')
            ->whereLike('SIGLA', "{$this->modulo}%")
            ->where('SIGLA', '<>', $this->modulo)
            ->get()
            ->toArray();
            
        return view('Livewire.Components.rotinas');
    }
}
