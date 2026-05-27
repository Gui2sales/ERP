<?php

namespace App\Livewire\Login;

use App\Models\User;
use App\Services\Logger;
use App\Services\NewOpusSocketService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $senha = "";
    public $usuario = "";
    public $remember = false;
    public $erro = "";
    protected $opus;

    public function login(NewOpusSocketService $opus)
    {
        if(!$this->usuario){
            return $this->erro = "Campo Usuário é obrigatório!";
        }

        if(!$this->senha){
            return $this->erro = "Campo Senha é obrigatório!";
        }
        
        $user = User::where('user', $this->usuario)->first();
        
        $retornoOpus = $opus->validaSenha($this->usuario, $this->senha, 'OPUS')['VALSENH'];

        Logger::logWithCooldown(
            event: 'login',
            properties: [
                'tentativa' => $user,
                'retorno'   => $retornoOpus,
                'ip'        => request()->ip(),
            ],
            seconds: 0,
            logName: 'tentativa de login',
            status: 'tempt',
            description: 'Tentativa de login via opus'
        );
        
        if($retornoOpus == "S" ){   

            if(!isset($user))
            {
                $usuarioOpus = $opus->getUsuarios($this->usuario)['user'][0];
                
                User::create([
                    'name' => $usuarioOpus['nome'],
                    'email' => $usuarioOpus['email'],
                    'user' => $this->usuario,
                    'ativo' => '1'
                ]);

                $user = User::where('user', $this->usuario)->first();
                
                $user->assignRole('Usuário Padrão');
            }

            Logger::logWithCooldown(
                event: 'login',
                properties: [
                    'tentativa' => $user,
                    'ip'        => request()->ip(),
                    'retorno'   => $retornoOpus
                ],
                seconds: 0,
                logName: 'tentativa de login',
                status: 'success',
                description: 'Tentativa de login '
            );

            Auth::login($user);

            session()->regenerate();

            return redirect()->intended('/')->with('success', 'Login realizado com sucesso!');
        }
        else
        {
            Logger::logWithCooldown(
                event: 'login',
                properties: [
                    'tentativa' => $user,
                    'ip'        => request()->ip(),
                    'retorno'   => $retornoOpus
                ],
                seconds: 0,
                logName: 'tentativa de login',
                status: 'failed',
                description: 'Tentativa de login via opus falhou, Senha/Usuário invalidos!'
            );
        
            return $this->erro = "Senha/Usuário invalidos!";
        }
    }

    public function render()
    {
        return view('Livewire.Login.Login');
    }
}
