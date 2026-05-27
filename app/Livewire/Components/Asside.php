<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Asside extends Component
{
    public $exibe;

    public function toggleExibe()
    {
        $this->exibe = !$this->exibe;
    }
    public function toggleExibeOff()
    {
        $this->exibe = false;
    }

    public function render()
    {
        return <<<'HTML'
        <div class="itens_aside" wire:click="toggleExibe" wire:click.outside="toggleExibeOff">
            <i class="bi bi-link-45deg icone_grande"></i>
            <span class="only_pc">Links</span>
            @if($exibe)
                <div id="card_asside">
                    <h5 class="mb-2">Links</h5>
                    <hr class="mb-3">
                    <div class="card_asside_item">
                        <a href="chrome-extension://iodihamcpbpeioajjeobimgagajmlibd/html/nassh.html?profile-id=c2c1#profile-id:c2c1" target="_blank" title="Opus">
                            <i class="bi bi-terminal icone_aside"></i>
                            <span>Opus</span>
                        </a>
                    </div>
                    <div class="card_asside_item">
                        <a href="https://portal.pacaembuautopecas.com.br/Corpore.Net/Login.aspx" target="_blank" title="Portal RH">
                            <i class="bi bi-person-vcard icone_aside"></i>
                            <span>Portal RH</span>
                        </a>
                    </div>
                    <div class="card_asside_item">
                        <a href="https://pabu.gupy.io/" target="_blank" title="Painel de Vagas">
                            <i class="bi bi-suitcase-lg icone_aside"></i>
                            <span>Painel de vagas</span>
                        </a>
                    </div>
                    <div class="card_asside_item">
                        <a href="https://sites.google.com/pabu.com.br/bloglgpd/in%C3%ADcio" target="_blank" title="LGPD">
                            <i class="bi bi-file-earmark-lock icone_aside"></i>
                            <span>LGPD</span>
                        </a>
                    </div>
                    <div class="card_asside_item">
                        <a href="https://helpdesk.pacaembuautopecas.com.br/front/central.php" target="_blank" title="Helpdesk">
                            <i class="bi bi-headset icone_aside"></i>
                            <span>GLPI</span>
                        </a>
                    </div>
                    <div class="card_asside_item">
                        <a href="https://auth.mobiliza.com.br/?service=https://unipabu.mobiliza.com.br/" target="_blank" title="Uni PABU">
                            <i class="bi bi-book icone_aside"></i>
                            <span>Uni Pabu</span>
                        </a>
                    </div>
                    <div class="card_asside_item">
                        <a href="https://helpdesk.pacaembuautopecas.com.br/marketplace/formcreator/front/formdisplay.php?id=23" target="_blank" title="Assinaturas de Email">
                            <i class="bi bi-envelope-at icone_aside"></i>
                            <span>Assinaturas de Email</span>
                        </a>
                    </div>
                </div>
            @endif            
        </div>
        HTML;
    }
}
