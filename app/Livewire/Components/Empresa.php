<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Empresa extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="inline-block mr-5">
            <select name="empresa" id="empresa" class="only_pc">
                <option value="1"> 01 - Pacaembu Auto Peças</option>
                <option value="5" disabled> 05 - Dadica Agropecuaria LTDA</option>
                <option value="10" disabled> 10 - Fazenda Luiz Cassorla</option>
            </select>
            <select name="empresa" id="empresa" class="only_celular">
                <option value="1">01</option>
                <option value="5" disabled>05</option>
                <option value="10" disabled>10</option>
            </select>
        </div>
        HTML;
    }
}
